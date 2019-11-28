<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryPhotoRepository")
 */
class GalleryPhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoUri;

    /**
     * @ORM\Column(type="datetime")
     */
    private $photoDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gallery", inversedBy="photos")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    private $gallery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoUri(): ?string
    {
        return $this->photoUri;
    }

    public function setPhotoUri(string $photoUri): void
    {
        $this->photoUri = $photoUri;
    }

    public function getPhotoDate(): ?\DateTimeInterface
    {
        return $this->photoDate;
    }

    public function setPhotoDate(\DateTimeInterface $photoDate): void
    {
        $this->photoDate = $photoDate;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(Gallery $gallery): void
    {
        $this->gallery = $gallery;
    }
}
