<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Model\ScoreDataIndexerInterface;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository implements ScoreDataIndexerInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    // /**
    //  * @return Score[] Returns an array of Score objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Score
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getCountOfUserWithinScoreRange(int $rangeStart, int $rangeEnd): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT Count(Score) AS total FROM score s WHERE s.Score >= '.$rangeStart.' AND s.Score <= '.$rangeEnd.'';

        $result = $conn->executeQuery($sql)->fetchAll();
        return $result[0]['total'];
    }

    public function getCountOfUsersByCondition(string $region, string $gender, bool $hasLegalAge, bool $hasPositiveScore): int
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = 'SELECT Count(Score) AS total FROM score s WHERE Region = "'.$region.'" AND Gender = "'.$gender.'"';
        if($hasLegalAge){
            $sql = $sql . 'AND Age >= 18';
        }
        if($hasPositiveScore){
            $sql = $sql . ' AND Score >= 0';
        }
        $result = $conn->executeQuery($sql)->fetchAll();
        return $result[0]['total'];
    }
}
