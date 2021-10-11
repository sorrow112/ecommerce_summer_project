<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\MessageFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\DocumentRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Entity\categorie;
use App\Entity\Commande;
use App\Entity\PanierAchat;
use App\Entity\Payement;
use App\Entity\Message;
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

class MainController extends AbstractController
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
    * @Route("/user", name="user")
    */
    public function user(Request $request,SessionInterface $session ,ProduitRepository $produitRepository): Response{
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $produits = $session->get('panier',[]);


        $userID = $this->getUser()->getId();
        $repository = $this->getDoctrine()->getRepository(PanierAchat::class);
        $paniers = $repository->findPanier($userID);
        $repositoryC = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = [];
        $repositoryP =$this->getDoctrine()->getRepository(Payement::class);
        $payements = [];
        for ($i = 0; $i < count($paniers); $i++) { 

            $commandes[$j] = findCommandes($paniers[$j]->getId());
        }


        return $this->render('main/index.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'souscats' => $souscat,
            'cat' => $souscat[1],
            'items' => $panierWithData,
            'total' => $produits["total"]
        ]);
    }

    /** 
    * @Route("/contactus", name="contact")
    */
    public function contactus(Request $request,SessionInterface $session ,ProduitRepository $produitRepository): Response{
        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
        }
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $produits = $session->get('panier',[]);
        if ($this->getUser() == null) {
            return $this->render('main/contactus.html.twig', ['user' => '', 'categories' => $categories, 'souscats' => $souscat,'items'=> [],'messageForm' => $form->createView()]);

        } else {
            return $this->render('main/contactus.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'items' => $panierWithData,
                'total' => $produits["total"],
                'messageForm' => $form->createView(),
                
            ]);
        }
    }

    /**
     * @Route("/", name="root")
     */
    public function index(Request $request,SessionInterface $session ,ProduitRepository $produitRepository): Response
    {
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $produits = $session->get('panier',[]);


        if ($this->getUser() == null) {
            return $this->render('main/index.html.twig', ['user' => '', 'categories' => $categories, 'souscats' => $souscat,'items'=> []]);

        } else {
            return $this->render('main/index.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'cat' => $souscat[1],
                'items' => $panierWithData,
                'total' => $produits["total"]
            ]);
        }
    }
/**
     * @Route("/showprod/{prodID}", name="product")
     */
    public function showproduct(Request $request,int $prodID, SessionInterface $session 
    ,DocumentRepository $docRepository,ProduitRepository $produitRepository): Response
    {
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $product = $produitRepository->findProduct($prodID);
        $produits = $session->get('panier',[]);
        $docs = $docRepository->getDoc($prodID);

        if ($this->getUser() == null) {
            return $this->render('main/product.html.twig', ['user' => '','docs' => $docs, 'categories' => $categories, 'souscats' => $souscat,'items'=> [], 'product' => $product]);

        } else {
            return $this->render('main/product.html.twig', [
                'user' => $this->getUser(),
                'docs' => $docs,
                'categories' => $categories,
                'souscats' => $souscat,
                'cat' => $souscat[1],
                'items' => $panierWithData,
                'total' => $produits["total"],
                'product' => $product
            ]);
        }
    }
    /**
     * @Route("/aboutus", name="aboutus")
     */
    public function aboutus(Request $request,SessionInterface $session ,ProduitRepository $produitRepository): Response
    {
        $souscat = $this->getSousCat();
        $categories = $this->getCategory();
        $panierWithData = $this->getPanier($request ,$session, $produitRepository);
        $produits = $session->get('panier',[]);
            return $this->render('main/aboutus.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categories,
                'souscats' => $souscat,
                'items' => $panierWithData,
                'total' => $produits["total"]
                
            ]);
    }

    function getPanier(Request $request,SessionInterface $session, ProduitRepository $produitRepository){
            
        $panier = $session->get('panier',[]);
        $panierWithData = [];
        $panier["uri"]= $uri = $request->getUri();
        if(empty($panier["total"])){
            $panier["total"]=0;
        }
        foreach ($panier as $id => $quantity){
            
            
            
            $panierWithData[]=[
                'product' => $produitRepository->find($id),
                'quantity' => $quantity,   
            ];
        }
        $session->set('panier', $panier);
        
        return $panierWithData;
    }

        /**
        * @Route("/show/{souscatID}", name="showall")
        */
        public function showall(Request $request,int $souscatID, SessionInterface $session, ProduitRepository $produitRepository): Response
        {
            $categories = $this->getCategory();
            $souscat = $this->getSousCat();
            $products = $produitRepository->findProducts($souscatID);
            $panierWithData = $this->getPanier($request ,$session, $produitRepository);
            $produits = $session->get('panier',[]);
            
            if ($this->getUser() == null) {
                return $this->render('main/show.html.twig', ['user' => '', 'categories' => $categories, 'souscats' => $souscat, 'products' => $products,
                'items'=> []]);
            } else {
                return $this->render('main/show.html.twig', [
                    'user' => $this->getUser(),
                    'categories' => $categories,
                    'souscats' => $souscat,
                    'products' => $products,
                    'items' => $panierWithData,
                    'cat' => $souscatID,
                    'total' => $produits["total"]
                ]);
            }
        }
        
}