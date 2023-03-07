<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findBy([],['titre' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository, ImageRepository $imgRep, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pics = $form->get('image')->getData();
            $annonce->setSlugger($slugger);
            foreach($pics as $pic){
                // On génère un nouveau nom de fichier
                $fichier = $pic->getClientOriginalName();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$annonce->getId().'-'.$annonce->getSlugger();
                
                // On copie le fichier dans le dossier uploads
                $pic->move(
                    $destination,
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Image();
                $img->setUrl($fichier);
                $annonce->addImage($img);
                $imgRep->save($img, true);
            }
            if(isset($img)){     // on vérifie qu'il y a bien une image à persister en BDD
                $img->setAnnonce($annonce);
            }
            $annonce->setAuteur($this->getUser());
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, ImageRepository $imgRep): Response
    {
        $this->denyAccessUnlessGranted('ANNONCE_EDIT', $annonce);
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pics = $form->get('image')->getData();
            foreach($pics as $pic){
                // On génère un nouveau nom de fichier
                $fichier = $pic->getClientOriginalName();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$annonce->getId().'-'.$annonce->getSlugger();
                
                // On copie le fichier dans le dossier uploads
                $pic->move(
                    $destination,
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Image();
                $img->setUrl($fichier);
                $annonce->addImage($img);
                $imgRep->save($img, true);
            }
            $img->setAnnonce($annonce);
            $annonce->setDatedemaj(new \DateTime);
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $this->denyAccessUnlessGranted('ANNONCE_DELETE', $annonce);
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $images = $annonce->getImage();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$annonce->getId().'-'.$annonce->getSlugger();
            foreach ($images as $img) {
                unlink($destination."/".$img->getUrl());
                $img->setAnnonce(null);
            }
            rmdir($destination);
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }
}
