<?php

//declare(strict_types=1);

namespace App\API\Controller;

use App\Repository\GalleryRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/api/gallery", name="api-gallery-list", methods={"GET"})
     * @param GalleryRepository $galleryRepository
     *
     * @return JsonResponse
     */
    public function list(GalleryRepository $galleryRepository): JsonResponse
    {
        $galleries = $galleryRepository->findAllAsArray();

        return $this->json($galleries);
    }

    /**
     * @Route("/api/gallery/{galleryId}", name="api-gallery-one", methods={"GET"})
     * @param int                 $galleryId
     * @param GalleryRepository   $galleryRepository
     *
     * @param SerializerInterface $serializer
     *
     * @return JsonResponse
     */
    public function getOne(
        int $galleryId,
        GalleryRepository $galleryRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $gallery = $galleryRepository->find($galleryId);

        $gallery = $serializer->serialize($gallery, 'json');

        return new JsonResponse($gallery, 200, [], true);
    }
}
