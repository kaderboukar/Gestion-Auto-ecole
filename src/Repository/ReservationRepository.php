<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

   /**
    * @return Reservation[] Returns an array of Reservation objects
    */
   public function findByTestDoubleField($etudiant,$isntru,$date,$heure): array
   {
        //dd($date->format('Y-m-d'));
       return $this->createQueryBuilder('r')
           ->andWhere('r.id_etudiant = :id_etudiant and r.id_instructeur = :id_instructeur and r.date_reservation LIKE :date_reservation and r.heure_reservation LIKE :heure_reservation and (r.status = :staus1 or r.status = :staus)')

           ->setParameter('id_etudiant', $etudiant)
           ->setParameter('id_instructeur', $isntru)
           ->setParameter('date_reservation', $date->format('Y-m-d'))
           ->setParameter('heure_reservation', $heure->format('H:i:s'))
           ->setParameter('staus', 1)
           ->setParameter('staus1', 2)

           ->orderBy('r.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
