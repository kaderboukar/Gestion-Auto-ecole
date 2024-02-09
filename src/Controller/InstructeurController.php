<?php

namespace App\Controller;

use App\Entity\Instructeur;
use App\Entity\User;
use App\Form\InstructeurType;
use App\Repository\InstructeurRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/instructeur')]
class InstructeurController extends AbstractController
{
    #[Route('/', name: 'app_instructeur_index', methods: ['GET'])]
    public function index(InstructeurRepository $instructeurRepository): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('instructeur/index.html.twig', [
            'instructeurs' => $instructeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_instructeur_new', methods: ['GET', 'POST'])]//ajout
    #[Route('/{id}/edit', name: 'app_instructeur_edit', methods: ['GET', 'POST'])]//modification
    public function new(Request $request,UserRepository $UserRepository, Instructeur $instructeur=null, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        
        if ($instructeur==null) {
            # code...
             $instructeur = new Instructeur();
             $user = new User();
             $edit=0;
        }else{
             $user=$UserRepository->findOneBy(['id_instructeur'=>$instructeur->getId()]);
             $edit=1;

        }
       

        $form = $this->createForm(InstructeurType::class, $instructeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($instructeur==null) {
           
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                1234
            );
           }
            $entityManager->persist($instructeur);
           if ($instructeur!=null) {
            if ($instructeur->getEmail()!=$form->get('email')->getData()) {
                # code...
                $ExisteUser=$UserRepository->findBy(['email'=>$form->get('email')->getData(),'status'=>[0,1]]);
                if ($ExisteUser!=null) {
                # code...
                 $this->addFlash('alertCreate', "Ce email a été deja utilisé comme utilisateur");
                return $this->redirectToRoute('app_instructeur_new', [], Response::HTTP_SEE_OTHER);
               }
            }
           }else{
             $ExisteUser=$UserRepository->findBy(['email'=>$form->get('email')->getData(),'status'=>[0,1]]);
             if ($ExisteUser!=null) {
                # code...
                 $this->addFlash('alertCreate', "Ce email a été deja utilisé comme utilisateur");
                return $this->redirectToRoute('app_instructeur_new', [], Response::HTTP_SEE_OTHER);
            }
           }
            

            //insertion dans la table user
            $user->setLastName($form->get('nom')->getData());
            $user->setFirstName($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            if ($instructeur==null) {
            $user->setIdInstructeur($instructeur);
            $user->setFirstConnexion(0);
            $user->setPassword($hashedPassword);
            $user->setRoles(array("ROLE_INSTRUCTEUR"));
            }
            $user->setEmail($form->get('email')->getData());
            $entityManager->persist($user);

            //dd($etudiant,$user);

            $entityManager->flush();
            if ($instructeur==null) {
               $this->addFlash('alertCreate', "Ajout instructeur a été effectuée avec succès, avec un mot de passe par defaut 1234");
             }else{
               $this->addFlash('alertCreate', "Modification instructeur a été effectuée avec succès");

             }
            return $this->redirectToRoute('app_instructeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructeur/new.html.twig', [
            'instructeur' => $instructeur,
            'form' => $form,
            'edit' => $edit,
            //variable edit 0 =>ajout 
            //variable edit 1 =>modification 
        ]);
    }

    #[Route('/{id}', name: 'app_instructeur_show', methods: ['GET'])]
    public function show(Instructeur $instructeur): Response
    {
        return $this->render('instructeur/show.html.twig', [
            'instructeur' => $instructeur,
        ]);
    }

   
    #[Route('/{id}', name: 'app_instructeur_delete', methods: ['POST'])]
    public function delete(Request $request, Instructeur $instructeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instructeur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($instructeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_instructeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
