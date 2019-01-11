<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\TricksRepository;

class SnowController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / $this->getParameter('perpage.tricks');
        $tricks = $trickRepo->findBy([], null, $this->getParameter('perpage.tricks'), 0);
        // findBy([], ["dateCreate"=>"DESC"],
        // attention il faudra revoir toute la pagination

        return $this->render('snow/home.twig', [
                "tricks" => $tricks,
                "pageNb" => 1,
                "nbPages" => $nbPages
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactForm(Request $request, \Swift_Mailer $mailer)
    {
        if ($request->request->count() > 0) {
            if($this->checkReCaptcha($request->getClientIps(), $request->request->get('g-recaptcha-response'))) {
                $message = (new \Swift_Message('SnowTricks - Formulaire de contact'))
                    ->setFrom(strip_tags($request->request->get('contactEmail')))
                    ->setTo($this->getParameter('admin.email'))
                    ->setBody(
                        $this->renderView(
                            'emails/contact.html.twig',
                            array(
                                'name' => strip_tags($request->request->get('contactFirstname')) . " " . strip_tags($request->request->get('contactLastname')),
                                'subject' => strip_tags($request->request->get('contactSubject')),
                                'message' => strip_tags($request->request->get('contactMessage'))
                            )
                        ),
                        'text/html'
                    );
                $mailer->send($message);
                $this->addFlash('success', 'Votre Message à bien été envoyé.<br><strong>Merci.</strong>');
                return $this->redirectToRoute('home');
            }
            $this->addFlash('danger', 'Erreur sur le captcha !');
            return $this->redirectToRoute('contact', ["captchaSiteKey" => $this->getParameter('captcha.sitekey')]);
        }
        return $this->render('snow/contact.twig', ["captchaSiteKey" => $this->getParameter('captcha.sitekey')]);
    }
    
    /**
     * @Route("/mentions_legales", name="mentions")
     */
    public function mentionsPage()
    {
        return $this->render('snow/mentions.twig');
    }
    
    /**
     * @Route("/politiques_confidentialite", name="politique")
     */
    public function politiquePage()
    {
        return $this->render('snow/politique.twig');
    }
    

    private function checkReCaptcha($remoteIp, $captchaResponse)
    {
        $secret = $this->getParameter('captcha.secretkey');
        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $captchaResponse
            . "&remoteip=" . $remoteIp ;
        $decode = json_decode(file_get_contents($api_url), true);
        return $decode['success'];
    }
}
