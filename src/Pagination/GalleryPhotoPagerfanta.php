<?php

namespace App\Pagination;

use App\Entity\Gallery;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use PDO;

class GalleryPhotoPagerfanta
{
    /**
     * @var EntityRepository
     */
    private $galleryPhotoRepository;

    public function __construct(EntityRepository $galleryPhotoRepository)
    {
        $this->galleryPhotoRepository = $galleryPhotoRepository;
    }

    public function getPagerfanta(Gallery $gallery, int $currentPage, ?int $limit = 1): Pagerfanta
    {
        $galleryPhotoQueryBuilder = $this->galleryPhotoRepository->createQueryBuilder('gallery_photo');
        $galleryPhotoQueryBuilder->where('gallery_photo.gallery = :gallery');
        $galleryPhotoQueryBuilder->setParameter('gallery', $gallery->getId(), PDO::PARAM_INT);

        $adapter = new DoctrineORMAdapter($galleryPhotoQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($currentPage);

        return $pagerfanta;
    }
}
