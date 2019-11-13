<?php

namespace App\Infrastructure\Repository;

use App\Application\Filter\AccommodationFilter;
use App\Domain\Entity\Accommodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AccommodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accommodation::class);
    }

    public function findWithFilters(AccommodationFilter $accommodationFilter)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC');

        if ($accommodationFilter->getRating() != null) {
            $queryBuilder
                ->andWhere('a.rating = :rating')
                ->setParameter('rating', $accommodationFilter->getRating());
        }
        if ($accommodationFilter->getAvailabilityMoreThan() != null) {
            $queryBuilder
                ->andWhere('a.availability >= :availabilityMoreThan')
                ->setParameter('availabilityMoreThan', $accommodationFilter->getAvailabilityMoreThan());
        }
        if ($accommodationFilter->getAvailabilityLessThan() != null) {
            $queryBuilder
                ->andWhere('a.availability <= :availabilityLessThan')
                ->setParameter('availabilityLessThan', $accommodationFilter->getAvailabilityLessThan());
        }
        if ($accommodationFilter->getCategory() != null) {
            $queryBuilder
                ->andWhere('a.category = :category')
                ->setParameter('category', $accommodationFilter->getCategory());
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    public function findOneById(int $id): ?Accommodation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(Accommodation $accommodation): Accommodation
    {
        if ($accommodation->getId() != null) {
            throw new Exception("Was not possible create a accommodation because the entity already exists with id '{$accommodation->getId()}'");
        }

        $this->_em->persist($accommodation);
        $this->_em->flush();

        return $accommodation;
    }

    public function update(Accommodation $accommodation): void
    {
        $this->_em->persist($accommodation);
        $this->_em->flush();
    }

    public function delete(Accommodation $accommodation): void
    {
        $this->_em->remove($accommodation);
        $this->_em->flush();
    }
}
