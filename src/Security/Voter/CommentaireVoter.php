<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentaireVoter extends Voter
{
    public const EDIT = 'COMMENTAIRE_EDIT';
    public const DELETE = 'COMMENTAIRE_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Commentaire;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array("ROLE_ADMIN",$user->getRoles())) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if ($user === $subject->getAuteur()) {
                    return true;
                }
                break;
            case self::DELETE:
                if ($user === $subject->getAuteur()) {
                    return true;
                }
                break;
        }

        return false;
    }
}
