<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\SearchType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
    public function searchBar(Request $request){
        $value=[];
            $form = $this->createForm(SearchType::class, $value);
            $form->handleRequest($request);
//            if ($form->isSubmitted() ) {
 //
   //         }

            return $this->render('home/search.html.twig', [
                'form' => $form->createView()
            ]);
    }
}
