<?php

namespace App\Repository;

use App\Entity\Article;
use App\Model\ArticleFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param ArticleFilter $filter
     * @return Article[]
     */
    public function search(ArticleFilter $filter): array
    {
        $query = $this->createQueryBuilder('a');
        $name = $filter->getName();
        if (null !== $name) {
            $query->andWhere('a.title LIKE :title');
            $query->setParameter('title', '%' . $name .'%');
        }
        $dateRange = $filter->getDateRange();
        if (null !== $dateRange) {
            $query->andWhere('a.publishedAt BETWEEN :from AND :to');
            $query->setParameter('from', $dateRange->getFrom()->format('Y-m-d'));
            $query->setParameter('to', $dateRange->getTo()->format('Y-m-d'));
        }

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
