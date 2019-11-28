<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GalleryRepository $galleryRepository
     *
     * @return Response
     */
    public function index(GalleryRepository $galleryRepository): Response
    {
        $galleries = $galleryRepository->findAll();

        return $this->render('homepage.html.twig', [
            'galleries' => $galleries
        ]);
    }
}
