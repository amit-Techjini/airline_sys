<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class DefaultController extends Controller
{

    /**
     * @Route("/", name="index")
     */
    public function indexAction(){
        //default page view
        return $this->render('default/index.html.twig');
    }

}