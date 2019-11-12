<?php
namespace App\Infrastructure\Repository;

use App\Domain\Entity\Accommodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Accommodation|null findOneById(int $id)
 * @method Accommodation[] findAll()
 */
class AccommodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accommodation::class);
    }

    /**
     * @return Accommodation[] Returns an array of Accommodation objects
     */
    public function findAll()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Accommodation Returns a Accommodation object
     */
    public function findOneById(int $id): ?Accommodation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(Accommodation $accommodation)
    {
        $this->_em->persist($accommodation);
        $this->_em->flush();
    }
}
