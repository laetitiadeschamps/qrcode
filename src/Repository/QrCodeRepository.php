<?php

namespace App\Repository;

use App\Entity\QrCode;
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
      * Method to get all qrcodes shared with one user
      * @param User
      * @return QrCode[] Returns an array of QrCode objects
      */
    
    public function findShared($user)
    {
        return $this->createQueryBuilder('qrcode')
            ->where(':userId MEMBER OF qrcode.shared_with')
            ->setParameter(':userId', $user->getId())
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
