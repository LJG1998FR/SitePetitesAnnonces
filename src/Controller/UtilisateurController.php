<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\CoordonneeRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/mon-compte/{id}', name: 'app_utilisateur')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Utilisateur $utilisateur, CoordonneeRepository $coordRep): Response
    {
        $this->denyAccessUnlessGranted('UTILISATEUR_EDIT', $utilisateur);
        $form = $this->createForm(RegistrationFormType::class, $utilisateur);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur',['id' => $user->getId()]);
        }
        
        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
            'coordonnees' => $coordRep->findBy([], ['ville' => 'ASC']),
            'form' => $form->createView(),
        ]);
    }
}
