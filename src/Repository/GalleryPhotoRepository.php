<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GalleryPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GalleryPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryPhoto[]    findAll()
 * @method GalleryPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryPhotoRepository extends ServiceEntityRepository implements GalleryPhotoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryPhoto::class);
    }
}
