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

        // user is deleted, show a generic Account Not Found message.
        // if ($user->isDeleted()) {
        //     throw new AccountDeletedException('...');

            // or to customize the message shown
            // throw new CustomUserMessageAuthenticationException(
            //     'Your account was deleted. Sorry about that!'
            // );
        // }
        if (!$user->getValid()) {
            throw new CustomUserMessageAuthenticationException(
                'Votre incription n\'a pas encore été validée,<br>
                 Vous avez recu un email pour valider votre inscription,<br>
                 Pensez à verfiez vos courriers indésirable,<br>
                 <strong>Merci</strong>.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }

        // user account is expired, the user may be notified
        // if ($user->isExpired()) {
        //     throw new AccountExpiredException('...');
        // }
    }
}
