<?php

namespace App\Repository;

use App\Entity\Party;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Party>
 *
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Party::class);
    }

    public function save(Party $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Party $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Party[] Returns an array of Party objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Party
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//
    public function findNextSlug(string $slug): string
    {
        $result =  $this->createQueryBuilder('p')
            ->select('p.slug')
            ->where('p.slug LIKE :slug')
            ->setParameter('slug', $slug.'%')
            ->orderBy('p.slug', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if ($result) {
            $slugNumber = (int)str_replace($slug, '', $result['slug']) + 1;
            return $slug . $slugNumber;
        }
        return $slug;
    }

    public function findNextPartiesByUser(User $user, ?int $limit = null): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.users', 'u')
            ->join('p.propositionDates', 'pd')
            ->leftJoin('p.finalDate', 'fd')
            ->leftJoin('u.availables', 'a')
            ->where(new Orx([
                'p.creator = :user',
                'u = :user',
            ]))
            ->andWhere(new Orx(
                [
                    new Andx([
                        'fd IS NULL',
                        'pd.startingAt > :now',
                    ]),
                    'fd.startingAt > :now',
                ]
            ))
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->orderBy('CASE WHEN fd IS NOT NULL THEN fd.startingAt ELSE MIN(pd.startingAt) END', 'ASC')
            ->groupBy('p.id')
        ;
        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
            ->getResult()
        ;
    }
}
