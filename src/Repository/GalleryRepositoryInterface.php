<?php

declare(strict_types=1);

namespace App\Repository;

interface GalleryRepositoryInterface
{
    public function find(int $id);

    public function findAllAsArray(): iterable;

    public function findAllSortedByPhotosCount(string $order): iterable;
}
