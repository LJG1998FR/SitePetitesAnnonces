<?php

namespace App\Security\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $this->addFlash(
            'accessdenied',
            'Vous n\'avez pas les droits pour modifier cette annonce.'
        );
        $content = $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);

        return new Response($content, 403);
    }
}