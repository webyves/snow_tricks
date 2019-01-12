<?php
namespace App\Security;

use App\Exception\AccountDeletedException;
use App\Entity\Users;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }
        if (!$user->getValid()) {
            throw new CustomUserMessageAuthenticationException(
                'Votre incription n\'a pas encore été validée,<br>
                 Vous devez avoir recu un email pour valider votre inscription, contenant un lien valable 14 jours.<br>
                 Si ce n\'est pas le cas pensez à verfiez vos courriers indésirable, ou contacter un administrateur.<br>
                 <strong>Merci</strong>.'
             );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }
    }
}
