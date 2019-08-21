<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use AppBundle\Entity\Flight;
use AppBundle\Form\FlightType;
use AppBundle\Form\FlightEditType;




class AdminController extends Controller
{   
    /**
     * @Route("/login", name="_admin_login")
     */
    public function adminLoginAction(Request $request, AuthenticationUtils $authUtils){
            
            $admin = $this->getUser();
            $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authUtils->getLastUsername();
                       
            return $this->render('admin/login.html.twig' ,array(
                '_username' => $lastUsername,
                'error'     => $error
            ));
    }

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function indexAction()
    {
        // render the admin dashboard
        return $this->render('admin/dashboard.html.twig');
    }

    /**
     * @Route("/add-flight",name="add_flight")
     */
    public function addFlightAction(Request $request){
        
        $flight = new Flight();

        //form to add flight
        $form = $this->createForm(FlightType::class, $flight);
            
        // To handle the form data 
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            $flight = $form->getData();
            
            // create entity manager to insert the data 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flight);
            $entityManager->flush($flight);

            // render to admin dashboard 
            return $this->redirectToRoute('admin_dashboard');

        }

        return $this->render('admin/add-flight.html.twig',[
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/view-flight", name="view_flight")
     */
    public function viewFlightAction(){

        $flights = $this->getDoctrine()->getRepository(Flight::class)->findStatusActive();
       
        //render the view flight for admin with all the flight details
        return $this->render('admin/view-flight.html.twig',[
            "flights" => $flights
        ]);
    }

    /**
     * @Route("edit-flight/{flightId}",name="edit_flight")
     */
    public function editFlightAction(Request $request, $flightId){

        //fetching data form db to show in the edit form
        $flight = $this->getDoctrine()->getManager()
                       ->getRepository(Flight::class)
                       ->find($flightId);
       
        //edit form for flight details
        $form = $this->createForm(FlightEditType::class,$flight);
                
        //handles the form data
        $form->handleRequest($request);

        if($form->isSubmitted()){
           
            //creating entity manager to update flight details
            $entityManager = $this->getDoctrine()->getManager();
            $flight = $entityManager->getRepository(Flight::class)->find($flightId);
            
            //flushing the updated data
            $entityManager->flush();

            //redirecting to the view flight to see the updated details
            return $this->redirectToRoute("view_flight");
        }

        return $this->render('admin/edit-flight.html.twig',[
            "form"=>$form->createView()
        ]);
            
    }


    /**
     * @Route("/delete-flight/{flightId}", name="delete_flight")
     */
    public function deleteFlightAction($flightId){
        
        //entity manager to delete a flight's details
        $entityManager = $this->getDoctrine()->getManager();
        $flight = $entityManager->getRepository(Flight::class)->find($flightId);

        $flight->setStatus("inactive");// making the flight details inactive

        // $entityManager->remove($flight);
        $entityManager->flush();
        
        return $this->redirectToRoute('view_flight');
    }

    /**
     * @Route("/logout", name="_admin_logout")
     * 
     */
    public function logout(Request $request)
    {//LOGOUT for the admin
    }
}

