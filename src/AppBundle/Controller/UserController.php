<?php

namespace AppBundle\Controller;

//form type 
use AppBundle\Form\UserRegisterType; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Psr\Log\LoggerInterface;

use AppBundle\Entity\User;
use AppBundle\Entity\Flight;
use AppBundle\Entity\Booking;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserController extends Controller
{
    /**
     * @Route("/user/login", name="_user_login")
     */
    public function userLoginAction(Request $request, AuthenticationUtils $authUtils){
            
            $user = $this->getUser();
            
            //get the error if any 
            $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authUtils->getLastUsername();
                       
            return $this->render('user/login.html.twig' ,array(
                '_username' => $lastUsername,
                'error'     => $error
            ));
        
    }
 
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function userDashboardAction(Request $request){
       
        //to get the meta data bag of the session and fetch the lifetime of the session
        $sessionExp =$request->getSession()->getMetaDataBag()->getLifeTime();
        
        //fetches all flights Details
        $flights = $this->getDoctrine()->getRepository(Flight::class)->findAll();
        
        //rendering all the fight details for the user
        return $this->render('user/view-flight.html.twig',[
            "flights" => $flights,
            "sessionExpTime" => $sessionExp,
            "session" =>$_SESSION
        ]);
    }

    /**
     * @Route("/user/register", name="user_register")
     */
    public function userRegisterAction(Request $request){
        $user = new User();

        //form creation to register from UserRegisterType
        $form = $this->createForm(UserRegisterType::class,$user);

        //to handle the form data
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();

            $user = $form->getData();
        
            $entityManager->persist($user);
            $entityManager->flush($user);

            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('user/register.html.twig',[
            "form" => $form->createView()
        ]);        
    }

    /**
     * @Route("/user/book-flight/{flightId}/{flightName}/{noOfSeats}", name="book_flight")
     */
    public function bookFlightAction($flightId, $flightName, $noOfSeats){
        
        // $booking = new Booking();
       
        //setting the booking details
        // $booking->setFlightId($flightId);
        // $booking->setUserId($this->getUser()->getId());
        // $booking->setSeat($noOfSeats);
        // $booking->setCreatedAt(new \DateTime());

        //entity manager for insert the booking details
        $entityManager = $this->getDoctrine()->getManager();
        $booking = $this->getDoctrine()->getRepository(Booking::class)->addBookingDetails($flightId, $noOfSeats,$this->getUser()->getId());
           

        return $this->render('user/book-flight.html.twig', [
            "flightName" => $flightName,
            "noOfSeats" => $noOfSeats
        ]);
    }

    /**
     * @Route("/user/sessionExtend", name="user_session")
     */
    public function userSessionAction(Request $request,LoggerInterface $logger){
        $request->getSession()->getMetaDataBag()->stampNew(10);
        // $this->container->get('session')->migrate(true, 30);
        // dump($request->getSession());   die;
        //review this code before saving
        return new Response($request->getSession()->getMetaDataBag()->getLifeTime());
      
    }

     /**
     * @Route("/user/logout", name="_user_logout")
     * 
     */
    public function logout(Request $request)
    {//logout for the user
    }
    
}