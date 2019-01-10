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
        $nbPages = $nbTricks / getenv('TRICKS_PER_PAGE');
        $tricks = $trickRepo->findBy([], null, getenv('TRICKS_PER_PAGE'), 0);
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
            $message = (new \Swift_Message('SnowTricks - Formulaire de contact'))
                ->setFrom('contact@ybernier.fr')
                ->setTo(strip_tags($request->request->get('email')))
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        array(
                            'name' => "name", 
                            'message' =>"message")
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Votre Message à bien été envoyé.');
            return $this->redirectToRoute('home');
        }
        return $this->render('snow/contact.twig');
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
