<?php

namespace App\Repository;

use App\Entity\TennisMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TennisMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method TennisMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method TennisMatch[]    findAll()
 * @method TennisMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TennisMatch::class);
    }

    public function searchMatch($startHour, $endHour, $adress): array
    {
        $query = $this
            ->createQueryBuilder('t');

            if (!empty($startHour)) {
                $query = $query
                ->andWhere('t.startHour >= :startHour')
                ->setParameter('startHour', $startHour);
            }

            if (!empty($endHour)) {
                $query = $query
                ->andWhere('t.endHour <= :endHour')
                ->setParameter('endHour', $endHour);
            }

            if (!empty($adress)) {
                $query = $query
                ->andWhere('t.adress = :adress')
                ->setParameter('adress', $adress);
            }

            return $query->getQuery()->getResult();
    }
}
