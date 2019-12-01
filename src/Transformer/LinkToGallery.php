<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Gallery;
use App\Enum\WatchTheDeerURLEnum;
use DOMElement;

class LinkToGallery
{
    public function getGallery(DOMElement $element): Gallery
    {
        $galleryName = str_replace(["\r", "\n", "\r\n"], '', preg_replace('/\s+/', ' ', $element->textContent));
        $galleryUri = WatchTheDeerURLEnum::URL. str_replace(['../', 'viewer.aspx'], '', $element->getAttribute('href'));

        $gallery = new Gallery();
        $gallery->setName($galleryName);
        $gallery->setSourceUri($galleryUri);

        return $gallery;
    }
}
