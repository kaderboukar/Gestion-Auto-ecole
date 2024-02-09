<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;


#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request,UserRepository $UserRepository, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $etudiant = new Etudiant();
        $user = new User();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //creation de l'objet etudiant
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $etudiant->setPassword($hashedPassword);
            $entityManager->persist($etudiant);

             $ExisteUser=$UserRepository->findBy(['email'=>$form->get('email')->getData(),'status'=>[0,1]]);
            if ($ExisteUser!=null) {
                # code...
                 $this->addFlash('alertCreate', "Ce email a été deja utilisé comme utilisateur");
                return $this->redirectToRoute('app_instructeur_new', [], Response::HTTP_SEE_OTHER);
            }

            //insertion dans la table user
            $user->setLastName($form->get('nom')->getData());
            $user->setFirstName($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            $user->setIdEtudiant($etudiant);
            $user->setEmail($form->get('email')->getData());
            $user->setPassword($hashedPassword);
            $user->setRoles(array("ROLE_ETUDIANT"));

            $entityManager->persist($user);

            //dd($etudiant,$user);

            $entityManager->flush();
            $this->addFlash('alertCreate', "Votre inscription a été effectuée avec succès");
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }
}
