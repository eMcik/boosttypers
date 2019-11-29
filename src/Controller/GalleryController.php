<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GalleryPhotoRepository;
use App\Repository\GalleryRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery/{id}", name="gallery")
     * @param Request                $request
     * @param int                    $id
     * @param GalleryRepository      $galleryRepository
     *
     * @param GalleryPhotoRepository $galleryPhotoRepository
     *
     * @return Response
     */
    public function index(
        Request $request,
        int $id,
        GalleryRepository $galleryRepository,
        GalleryPhotoRepository $galleryPhotoRepository
    ): Response {
        $gallery = $galleryRepository->find($id);

        $galleryPhotoQueryBuilder = $galleryPhotoRepository->createQueryBuilder('gallery_photo');
        $galleryPhotoQueryBuilder->where('gallery_photo.gallery = :gallery');
        $galleryPhotoQueryBuilder->setParameter('gallery', $gallery->getId());

        $adapter = new DoctrineORMAdapter($galleryPhotoQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(1);
        $pagerfanta->setCurrentPage($request->get('page', 1));

        return $this->render('gallery.html.twig', [
            'gallery' => $gallery,
            'photos_pager' => $pagerfanta,
        ]);
    }
}
