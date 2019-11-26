<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourceUri;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GalleryPhoto", mappedBy="gallery")
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSourceUri(): ?string
    {
        return $this->sourceUri;
    }

    public function setSourceUri(string $sourceUri): void
    {
        $this->sourceUri = $sourceUri;
    }

    /**
     * @return Collection|GalleryPhoto[]
     */
    public function getGalleryPhotos(): Collection
    {
        return $this->photos;
    }
}
