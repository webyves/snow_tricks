<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use App\Entity\UserTokens;


class SnowTricksEmails
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    // send email from contact form
    public function sendContact(Request $request, $toEmail)
    {
        $message = (new \Swift_Message('SnowTricks - Formulaire de contact'))
            ->setFrom(strip_tags($request->request->get('contactEmail')))
            ->setTo($toEmail)
            ->setBody(
                $this->twig->render(
                    'emails/contact.html.twig',
                    array(
                        'name' => strip_tags($request->request->get('contactFirstname')) . " " . strip_tags($request->request->get('contactLastname')),
                        'subject' => strip_tags($request->request->get('contactSubject')),
                        'message' => strip_tags($request->request->get('contactMessage'))
                    )
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    // send email with a token (same function for reset password or registration)
    public function sendToken(Users $user, UserTokens $token, $fromEmail)
    {
        $subject = 'SnowTricks -';
        $view = '';
        if ($token->getType() === "registration") {
            $subject .= 'Votre Inscription';
            $view = 'emails/registration.html.twig';
        } elseif ($token->getType() === "reset_pwd") {
            $subject .= 'Reinitialisation de votre mot de passe';
            $view = 'emails/reset_pwd.html.twig';
        }
        if (!empty($view)) {
            $message = (new \Swift_Message($subject))
                ->setFrom($fromEmail)
                ->setTo($user->getEmail())
                ->setBody(
                    $this->twig->render(
                        $view,
                        array('user' => $user, 'token' => $token)
                    ),
                    'text/html'
                );
            $this->mailer->send($message);            
        }
    }
}
