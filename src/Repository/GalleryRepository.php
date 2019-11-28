<?php

namespace App\Repository;

use App\Entity\Gallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Gallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gallery[]    findAll()
 * @method Gallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gallery::class);
    }

    public function findAllSortedByPhotosCount(string $order): iterable
    {
        $qb = $this->createQueryBuilder('gallery');
        $qb->leftJoin('gallery.photos', 'photos');
        $qb->groupBy('gallery.id');
        $qb->orderBy('COUNT(photos.id)', $order);

        return $qb->getQuery()->execute();
    }
}
