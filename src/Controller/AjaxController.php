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
     * @Route("/ajax_tricks_list/{pageNb}", name="ajax_tricks_list", requirements={"pageNb"="\d+"})
     */
    public function tricksPages($pageNb, TricksRepository $trickRepo, Request $req)
    {
        if ($req->isXMLHttpRequest() ) {
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
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/ajax_comments_list/{pageNb}", name="ajax_comments_list", requirements={"pageNb"="\d+"})
     */
    public function commentsPages($pageNb, TrickCommentRepository $TrickCommentRepo, Request $req)
    {
        if ($req->isXMLHttpRequest() ) {
        	$trickid = $req->request->get("trickid");
	        $offset = ($pageNb * $this->getParameter('perpage.comments'));
	        $trickComments = $TrickCommentRepo->findBy(["trick"=>$trickid], null, $this->getParameter('perpage.comments'), $offset);
	        $nbPages = ($TrickCommentRepo->count(["trick"=>$trickid]) / $this->getParameter('perpage.comments')) - $pageNb;
	        $pageNb++;
	        return $this->render('ajax/ajaxCommentsList.twig', [
	                "trickComments" => $trickComments,
	                "pageNb" => $pageNb,
	                "nbPages" => $nbPages,
	                "trickid" => $trickid
	            ]);
        }
        return $this->redirectToRoute('home');
    }
}
