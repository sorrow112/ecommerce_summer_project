<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Entity\categorie;
use App\Entity\Commande;
use App\Entity\PanierAchat;
use App\Entity\Payement;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Form\paymentType;
use App\Paymentlocal;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Types\Integer;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{

    use TargetPathTrait;


    function getCategory(){
        $repository = $this->getDoctrine()->getRepository(categorie::class);
        $categories = $repository->findAll();
        return $categories;
    }
    function getSousCat(){
        $repository = $this->getDoctrine()->getRepository(SousCategorie::class);
        $souscat = $repository->findAll();
        return $souscat;
    }
    function getAllProds(){
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repository->findAll();
        return $produit;
    }

    /**
     * @Route("/submitpanel", name="submitpanel")
     */

    public function submitpanel(Request $request,SessionInterface $session ,ProduitRepository $produitRepository){
        $paniertemp = $this->getPanier($request ,$session, $produitRepository);

        $panierWithData = [];
        foreach ($paniertemp as $id => $data){
            
            $panierWithData[]=[
                'product' => $data["product"]->getId(),
                'quantity' => $data["quantity"],   
            ];
            
        }
        
        $pannel= $session->get('panier', []);

        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panier = new PanierAchat();
        $panier->setDateDeCreation(new \DateTime());
        $panier->setProduits($panierWithData);
        $panier->setMontant($pannel["total"]);
        $panier->setUser($this->getUser());
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();
        return $this->redirectToRoute('payment');
        
    }


    /**
     * @Route("/payment", name="payment")
     */
    public function payement(Request $request,SessionInterface $session ,ProduitRepository $produitRepository): Response
    {
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $panier = $session->get('panier',[]);
        

            return $this->render('main/payement.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'items' => $panierWithData,
                'total' => $panier["total"],
                'cat' => $categories[1]
            ]);

    }

    
        /**
     * @Route("/paypal", name="paypal")
     */
    public function paypal(Request $request, SessionInterface $session ,ProduitRepository $produitRepository): Response
    {
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $produits = $session->get('panier',[]);

        $allData = new Paymentlocal();
        $total = $produits["total"];
        $form = $this->createForm(paymentType::class, $allData);
        $form->handleRequest($request);
        $payment = new Payement();
        $commande = new Commande();
        $adress = $this->getUser()->getAdresses()[0];
        
        if ($form->isSubmitted() && $form->isValid() ) {        
            $payment->setDatePay(new \DateTime());
            $payment->setUser($this->getUser());
            $payment->setNumeroDeCarte($allData->getNumeroDeCarte());
            $payment->setMontant($total);

            $entityManager = $this->getDoctrine()->getManager();
            $date = new \DateTime();
            $commande->setDate(new \DateTime());
            $commande->setMontant($total);
            $commande->setAddress($adress);
            $commande->setPayement($payment);
            $commande->setUser($this->getUser());
            $entityManager->persist($commande);
            $payment->setCommande($commande);
            $entityManager->persist($payment);
            
            
            $entityManager->flush();
            $session->set('panier', []);
            $panierWithData = $this->getPanier($request ,$session, $produitRepository);
            return $this->render('main/success.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'items' => $panierWithData,
                'total' => $produits["total"],
                'cat' => $categories[1]
                
            ]);
            
        }
            return $this->render('main/paypal.html.twig', [
                'paymentForm' => $form->createView(),
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'items' => $panierWithData,
                'total' => $produits["total"],
                'cat' => $categories[1]
                
            ]);

    }

        function getPanier(Request $request,SessionInterface $session, ProduitRepository $produitRepository){
            
            $panier = $session->get('panier',[]);
            $panier["uri"]= $uri = $request->getUri();
        $panierWithData = [];
        if(empty($panier["total"])){
            $panier["total"]=0;
        }
        foreach ($panier as $id => $quantity){
            
            if ($produitRepository->find($id) === null) {
                continue;
            }
            
            $panierWithData[]=[
                'product' => $produitRepository->find($id),
                'quantity' => $quantity,   
            ];
        }

        $session->set('panier', $panier);
        
        return $panierWithData;
        }


        /**
        * @route("/panier/add/{id}", name="cart_add")
        */
        public function add_cart($id, SessionInterface $session, ProduitRepository $produitRepository){
            $panier = $session->get('panier', []);
            
            if(!empty($panier[$id])){
                $panier[$id]++;

            }
            else{
                $panier[$id] = 1;
            }

                $panier["total"] += $produitRepository->find($id)->getPrix();

           

            $session->set('panier', $panier);
            return $this->redirect($panier["uri"]);
           
}
/**
        * @route("/panier/remove/{id}", name="cart_remove")
        */
        public function remove_cart($id,  SessionInterface $session, ProduitRepository $produitRepository){
            $panier = $session->get('panier', []);
            $panier["total"] -= $produitRepository->find($id)->getPrix()*$panier[$id];

            if($panier[$id] > 0){
                unset($panier[$id]);

            }



            $session->set('panier', $panier);
            return $this->redirect($panier["uri"]);
           
}
}