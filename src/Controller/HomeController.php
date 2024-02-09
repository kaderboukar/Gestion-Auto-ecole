<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('home_frontEnd/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/backend', name: 'app_backend')]
    public function backend(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //Verfication si l'utilisateur est actif 
        if ($this->getUser()->getStatus()==1) {
            //Verifier si le profil de l'utilisateur pour la redirection de son profil
                if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())==true ){
                   return $this->redirectToRoute('app_instructeur_index');
                }elseif (in_array('ROLE_ETUDIANT', $this->getUser()->getRoles())==true ){
                   return $this->redirectToRoute('app_reservation_new');

                   
                }elseif (in_array('ROLE_INSTRUCTEUR', $this->getUser()->getRoles())==true ){
                   if($this->getUser()->isFirstConnexion()==true){

                     return $this->redirectToRoute('liste_instructeur');
                   }else{
                    return $this->redirectToRoute('update_password');
                    
                   }
                }else{
                   return $this->redirectToRoute('app_logout');
                }
       //sinon deconnexion
        }else{

            return $this->redirectToRoute('app_logout');
            
        }
    }


}
