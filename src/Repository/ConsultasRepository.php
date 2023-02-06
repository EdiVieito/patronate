<?php

namespace App\Repository;

use App\Entity\Consultas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultas>
 *
 * @method Consultas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultas[]    findAll()
 * @method Consultas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultas::class);
    }

    public function save(Consultas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Consultas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Consultas[] Returns an array of Consultas objects
//     */
    public function findByUserId($user,$curso): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.user = :user','c.curso = :curso')
            ->setParameters(['user'=> $user,
                            'curso'=> $curso])
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
//     * @return Consultas[] Returns an array of Consultas sin responder
//     */
public function findAllSinResponder(): array
{
    return $this->createQueryBuilder('c')
        ->select('c')
        ->andWhere('c.Respuesta is null')
        ->orderBy('c.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
}


//    public function findOneBySomeField($value): ?Consultas
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
