<?php

declare(strict_types=1);

namespace spec\App\Pagination;

use App\Entity\Gallery;
use App\Pagination\GalleryPhotoPagerfanta;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;
use PDO;
use PhpSpec\ObjectBehavior;

/**
 * @codingStandardsIgnoreFile
 */
class GalleryPhotoPagerfantaSpec extends ObjectBehavior
{
    public function let(EntityRepository $galleryPhotoRepository): void
    {
        $this->beConstructedWith($galleryPhotoRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GalleryPhotoPagerfanta::class);
    }

    public function it_should_return_pagerfanta(
        Gallery $gallery,
        EntityRepository $galleryPhotoRepository,
        QueryBuilder $queryBuilder
    ): void {
        $gallery->getId()->shouldBeCalled()->willReturn(1);

        $galleryPhotoRepository->createQueryBuilder('gallery_photo')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->where('gallery_photo.gallery = :gallery')->shouldBeCalled();
        $queryBuilder->setParameter('gallery', 1, PDO::PARAM_INT)->shouldBeCalled();
        $queryBuilder->getQuery()->shouldBeCalled();

        $this->getPagerfanta($gallery, 1, 1)->shouldBeAnInstanceOf(Pagerfanta::class);
    }
}
