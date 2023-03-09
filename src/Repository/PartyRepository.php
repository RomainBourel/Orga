<?php

namespace App\Repository;

use App\Entity\Party;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->select('p.id, p.slug')
            ->where('p.slug LIKE :slug')
            ->setParameter('slug', $slug.'%')
            ->orderBy('p.id', 'DESC')
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

    public function findNextPartiesByUser(User $user, ?int $limit = null, bool $all = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.users', 'u')
            ->join('p.propositionDates', 'pd')
            ->where(new Orx([
                'p.creator = :user',
                'u = :user',
            ]))
            ->setParameter('user', $user)
        ;
        if (!$all) {
            $qb
                ->andWhere('pd.startingAt > :today')
                ->setParameter('today', new \DateTime('today'))
            ;
        }
        $qb
            ->andWhere(new Orx([
                'pd.finalDate = true',
                'pd.finalDate is null',
            ]))
            ->addOrderBy('pd.startingAt', 'ASC')
            ->groupBy('p.id')
        ;
        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
            ->getResult()
        ;
//          Example of SQL request that will be generated with userId = 1, without limit and $all = true
//          (I have adding select to see just important information but with dql I don't need to do that because I want to get Party object)
//
//              SELECT party.id, party.name, proposition_date.starting_at  FROM `party`
//              INNER JOIN `party_user` ON party_user.party_id = party.id
//              INNER JOIN `user` ON party_user.user_id = user.id
//              INNER JOIN `proposition_date` ON party.id = proposition_date.party_id
//              WHERE (party.creator_id = 1 OR user.id = 1) AND (proposition_date.final_date IS true OR proposition_date.final_date IS null)
//              GROUP BY party.id
//              ORDER BY proposition_date.starting_at ASC;
    }
}
