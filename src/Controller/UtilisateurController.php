<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/mon-compte/{id}', name: 'app_utilisateur')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Utilisateur $utilisateur): Response
    {
        $this->denyAccessUnlessGranted('UTILISATEUR_EDIT', $utilisateur);
        if($request->isMethod('POST')){
            $user = $this->getUser();

            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $request->request->get('pass')
                    )
                );
                $entityManager->flush();
                $this->addFlash('message', 'Mot de passe modifié!');

                return $this->redirectToRoute('app_utilisateur',['id' => $user->getId()]);
            }else{
                $this->addFlash('error', 'Mots de passe différents.');
            }
        }
        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
}
