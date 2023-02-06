<?php

namespace App\Repository;

use App\Entity\Solicitudes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Solicitudes>
 *
 * @method Solicitudes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solicitudes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solicitudes[]    findAll()
 * @method Solicitudes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solicitudes::class);
    }

    public function save(Solicitudes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Solicitudes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function findAllSolicitudes(){
        return $this->getEntityManager()
            ->createQuery('
                SELECT solicitudes
                FROM App:solicitudes solicitudes
                ORDER BY solicitudes.id DESC
                '
            )
            ->getResult();
    }

    public function findByUser($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.User = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCurso($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.Curso = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Solicitudes
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
