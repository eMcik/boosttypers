<?php

declare(strict_types=1);

namespace spec\App\Transformer;

use App\Entity\Gallery;
use App\Enum\WatchTheDeerURLEnum;
use App\Transformer\LinkToGallery;
use DOMElement;
use PhpSpec\ObjectBehavior;

/**
 * @codingStandardsIgnoreFile
 */
class LinkToGallerySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(LinkToGallery::class);
    }

    public function it_should_transform_link_to_gallery(): void
    {
        $element = new DOMElement('a', '<a href="'.WatchTheDeerURLEnum::URL.'">TEST</a>');

        $this->getGallery($element)->shouldBeAnInstanceOf(Gallery::class);
    }
}
