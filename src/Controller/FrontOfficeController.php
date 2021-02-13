<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/frontoffice", name="front_office")
     */
    public function index(): Response
    {
        $nbAuteurs=count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbEditeurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        $nbLivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $livres=$this->getDoctrine()->getRepository(Livre::class)->findAll();
        $nbCategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        return $this->render('front_office/index.html.twig', [
            'nbAuteurs' => $nbAuteurs,
            'nbLivres' => $nbLivres,
            'livres'=>$livres,
            'nbCategories' => $nbCategories,
            'nbEditeurs' => $nbEditeurs,
        ]);
    }
}
