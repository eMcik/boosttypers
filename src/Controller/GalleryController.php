<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery/{id}", name="gallery")
     * @param int               $id
     * @param GalleryRepository $galleryRepository
     *
     * @return Response
     */
    public function index(int $id, GalleryRepository $galleryRepository): Response
    {
        $gallery = $galleryRepository->find($id);

        return $this->render('gallery.html.twig', [
            'gallery' => $gallery
        ]);
    }
}
