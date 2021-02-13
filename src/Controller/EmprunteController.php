<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Emprunte;
use App\Entity\Livre;
use App\Entity\User;
use App\Form\EmprunteType;
use App\Repository\EmprunteRepository;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/emprunte")
 */
class EmprunteController extends AbstractController
{
    /**
     * @Route("/index", name="emprunte_index")
     */
    public function index(EmprunteRepository $emprunteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $nbAuteurs=count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbEditeurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        $nbLivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbCategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        $user=$this->getUser();
        $empruntes=$emprunteRepository->findBy(['user'=>$user]);
        return $this->render('emprunte/index.html.twig', [
            'nbAuteurs' => $nbAuteurs,
            'nbLivres' => $nbLivres,
            'nbCategories' => $nbCategories,
            'nbEditeurs' => $nbEditeurs,
            'empruntes'=>$empruntes,
        ]);

    }

    /**
     * @Route("/all",name="all_empruntes",methods={"GET","POST"})
     */
    public function tousLesEmpruntes(EmprunteRepository $emprunteRepository){
        $empruntes=$emprunteRepository->findAll();
        return $this->render('emprunte/all_empruntes.html.twig',
            [
                'titre'=>'empruntes',
                'soustitre'=>'tous',
                'empruntes'=>$empruntes,
                'lien'=>$this->generateUrl('all_empruntes')
            ]);
    }
    /**
     * @Route("/livre_emprunter/{id}", name="livre_emprunter", methods={"GET","POST"})
     */
    public function emprunter(Request $request,int $id,LivreRepository $rep){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $nbAuteurs=count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbEditeurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        $nbLivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbCategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        $user=$this->getUser();
        $livre=$rep->find($id);
           // $livre->setNbExemplaire($livre->getNbExemplaire()-1);

        $emprunte=new Emprunte();
        $emprunte->setUser($user);
        $emprunte->setLivre($livre);
        $form = $this->createForm(EmprunteType::class, $emprunte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunte);
            $entityManager->flush();

            return $this->redirectToRoute('emprunte_index');
        }

        return $this->render('emprunte/new.html.twig', [
            'emprunte' => $emprunte,
            'form' => $form->createView(),
            'nbAuteurs' => $nbAuteurs,
            'nbLivres' => $nbLivres,
            'nbCategories' => $nbCategories,
            'nbEditeurs' => $nbEditeurs,

        ]);

    }

    /**
     * @Route("/edit/{id}",name="emprunte_edit",methods={"GET","POST"})
     */
    public function edit($id,Request $request,EmprunteRepository $emprunteRepository,LivreRepository $livreRepository){
        $this->denyAccessUnlessGranted('ROLE_USER');
        $nbAuteurs=count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbEditeurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        $nbLivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbCategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        $emprunte=new Emprunte();
       $livre=$livreRepository->find($id);
        $emprunte= $emprunteRepository->findOneBy(['livre'=>$livre,'user'=>$this->getUser()]);
        $form = $this->createForm(EmprunteType::class,$emprunte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emprunte_index');
        }

        return $this->render('emprunte/edit.html.twig', [
            'emprunte' => $emprunte,
            'form' => $form->createView(),
            'nbAuteurs' => $nbAuteurs,
            'nbLivres' => $nbLivres,
            'nbCategories' => $nbCategories,
            'nbEditeurs' => $nbEditeurs,

        ]);
    }


    public function delete($id,Request $request, Emprunte $emprunte,EmprunteRepository $emprunteRepository,LivreRepository $livreRepository): Response
    {
      /*  $this->denyAccessUnlessGranted('ROLE_USER');

        $livre=$livreRepository->find($id);
            $emprunte= $emprunteRepository->findOneBy(['user'=>$this->getUser(),'livre'=>$livre]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emprunte);
            $entityManager->flush();*/


        return $this->redirectToRoute('emprunte_index');
    }
    /**
     * @Route("/{id}", name="emprunte_delete", methods={"GET"})
     */
    public function delete1($id,LivreRepository $livreRepository,EmprunteRepository $emprunteRepository){
        $livre=$livreRepository->find($id);
        $emprunte= $emprunteRepository->findOneBy(['user'=>$this->getUser(),'livre'=>$livre]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($emprunte);
        $entityManager->flush();
        return $this->redirectToRoute('emprunte_index');

    }

}
