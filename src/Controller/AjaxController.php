<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TricksRepository;
use App\Repository\TrickCommentRepository;


class AjaxController extends AbstractController
{

    /**
     * @Route("/ajax_tricks_list/{pageNb}", name="ajax_tricks_list", requirements={"pageNb"="\d+"}, 
     * condition="context.getMethod() in ['POST', 'GET'] and request.headers.get('X-Requested-With') matches '/XMLHttpRequest/i'")
     */
    public function tricksPages($pageNb, TricksRepository $trickRepo)
    {
        $offset = ($pageNb * $this->getParameter('perpage.tricks'));
        $tricks = $trickRepo->findBy([], ["dateCreate"=>"DESC"], $this->getParameter('perpage.tricks'), $offset);
        $nbPages = ($trickRepo->count([]) / $this->getParameter('perpage.tricks')) - $pageNb;
        $pageNb++;
        return $this->render('ajax/ajaxTricksList.twig', [
                "tricks" => $tricks,
                "pageNb" => $pageNb,
                "nbPages" => $nbPages
            ]);
    }
    
    /**
     * @Route("/ajax_comments_list/{pageNb}", name="ajax_comments_list", requirements={"pageNb"="\d+"}, 
     * condition="context.getMethod() in ['POST', 'GET'] and request.headers.get('X-Requested-With') matches '/XMLHttpRequest/i'")
     */
    public function commentsPages($pageNb, TrickCommentRepository $TrickCommentRepo, Request $req)
    {
    	$trickid = $req->request->get("trickid");
        $offset = ($pageNb * $this->getParameter('perpage.comments'));
        $trickComments = $TrickCommentRepo->findBy(["trick"=>$trickid], ["dateCreate"=>"DESC"], $this->getParameter('perpage.comments'), $offset);
        $nbPages = ($TrickCommentRepo->count(["trick"=>$trickid]) / $this->getParameter('perpage.comments')) - $pageNb;
        $pageNb++;
        return $this->render('ajax/ajaxCommentsList.twig', [
                "trickComments" => $trickComments,
                "pageNb" => $pageNb,
                "nbPages" => $nbPages,
                "trickid" => $trickid
            ]);
    }
}
