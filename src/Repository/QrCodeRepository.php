<?php

namespace App\Repository;

use App\Entity\QrCode;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QrCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method QrCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method QrCode[]    findAll()
 * @method QrCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QrCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QrCode::class);
    }

     /**
      * Method to get all qrcodes shared with one user and not expired
      * @param User
      * @return QrCode[] Returns an array of QrCode objects
      */
    
    public function findShared($user)
    {
        $today = new DateTime();
        return $this->createQueryBuilder('qrcode')
            ->where(':userId MEMBER OF qrcode.shared_with')
            ->andWhere('qrcode.expires_at > :today OR qrcode.expires_at is NULL')
            ->setParameter(':userId', $user->getId())
            ->setParameter(':today', $today->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;
    }
        /**
      * Method to get all qrcodes owned by one user and not expired
      * @param User
      * @return QrCode[] Returns an array of QrCode objects
      */
    
      public function findOwned($user)
      {
        $today = new DateTime();
          $today = new DateTime();
          return $this->createQueryBuilder('qrcode')
              ->where('qrcode.author = :userId')
              ->andWhere('qrcode.expires_at > :today OR qrcode.expires_at is NULL')
              ->setParameter(':userId', $user->getId())
              ->setParameter(':today', $today->format('Y-m-d'))
              ->getQuery()
              ->getResult()
          ;
      }
      

    /*
    public function findOneBySomeField($value): ?QrCode
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
