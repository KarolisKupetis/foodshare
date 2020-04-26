<?php

namespace Publication\Creator;

use Doctrine\ORM\EntityManager;
use Publication\Entity\Image;

class ImageCreator
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $data
     * @return Image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createImage($data): ?Image
    {
        $image = $this->createImageEntity($data);

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    private function createImageEntity($data)
    {
        $image = new Image();

        $image->setPublication($data['publication'] ?? null);
        $image->setName($data['name']);

        return $image;
    }
}