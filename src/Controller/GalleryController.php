<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Gallery;
use App\Pagination\GalleryPhotoPagerfanta;
use App\Repository\GalleryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery/{id}", name="gallery")
     * @param Request                    $request
     * @param int                        $id
     * @param GalleryRepositoryInterface $galleryRepository
     * @param GalleryPhotoPagerfanta     $galleryPhotoPagerfanta
     *
     * @return Response
     */
    public function index(
        Request $request,
        int $id,
        GalleryRepositoryInterface $galleryRepository,
        GalleryPhotoPagerfanta $galleryPhotoPagerfanta
    ): Response {
        $gallery = $galleryRepository->find($id);

        if (!$gallery instanceof Gallery) {
            throw $this->createNotFoundException('Gallery not found');
        }

        $pagerfanta = $galleryPhotoPagerfanta;

        return $this->render('gallery.html.twig', [
            'gallery' => $gallery,
            'photos_pager' => $pagerfanta,
        ]);
    }
}
