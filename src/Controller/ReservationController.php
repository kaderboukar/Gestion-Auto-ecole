<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findBy(['status'=>[1,2,0]]),
        ]);
    }

     #[Route('/liste_instructeur', name: 'liste_instructeur', methods: ['GET'])]
    public function liste_instructeur(ReservationRepository $reservationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

         if($this->getUser()->isFirstConnexion()==true){ ///verufication si l'utilisateur a fait sa premiere connexion

        return $this->render('home_backend/instructeur.html.twig', [
            'reservations' => $reservationRepository->findBy(['id_instructeur'=>$this->getUser()->getIdInstructeur()->getId(),'status'=>[1,2,0]]),
        ]);
        }else{

            return $this->redirectToRoute('backend');

        }
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ReservationRepository $reservationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
          
            $ExisteReserve=$reservationRepository->findByTestDoubleField($this->getUser()->getIdEtudiant()->getId(),$form->get('id_instructeur')->getData(),$form->get('date_reservation')->getData(),$form->get('heure_reservation')->getData());
           //  dd($ExisteReserve);
            if ($ExisteReserve!=null) {
                # code...
                 $this->addFlash('alertCreate', "Une insertion avec les memes information est deja en cours de traitement");
                return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
            }
             $reservation->setIdEtudiant($this->getUser()->getIdEtudiant());

            $entityManager->persist($reservation);

            //dd($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}{action}/acceptation', name: 'app_reservation_acceptation', methods: ['GET'])]
    public function app_reservation_acceptation(Reservation $reservation,$action, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($action==1) {
            # code...
            $reservation->setStatus(1);
        }else{
            $reservation->setStatus(0);

        }
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('liste_instructeur', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
