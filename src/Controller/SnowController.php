<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\TricksRepository;

use App\Service\ReCpatchaV2;
use App\Service\SnowTricksEmails;

class SnowController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(TricksRepository $trickRepo)
    {
        $nbTricks = $trickRepo->count([]);
        $nbPages = $nbTricks / $this->getParameter('perpage.tricks');
        $tricks = $trickRepo->findBy([], ["dateCreate"=>"DESC"], $this->getParameter('perpage.tricks'), 0);

        return $this->render('snow/home.twig', [
                "tricks" => $tricks,
                "pageNb" => 1,
                "nbPages" => $nbPages
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactForm(Request $request, SnowTricksEmails $emailService)
    {
        if ($request->request->count() > 0) {
            if(ReCpatchaV2::checkValue($request, $this->getParameter('captcha.secretkey'))) {
                $emailService->sendContact($request, $this->getParameter('admin.email'));
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
}
