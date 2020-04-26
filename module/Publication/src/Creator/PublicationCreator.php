<?php

namespace Publication\Creator;

use Doctrine\ORM\EntityManager;
use Publication\Entity\Publication;
use User\Service\UserService;

class PublicationCreator
{

    /** @var UserService */
    private $userService;

    /** @var EntityManager */
    private $entityManager;

    /** @var ImageCreator */
    private $imageCreator;

    public function __construct(
        UserService $userService,
        EntityManager $entityManager,
        ImageCreator $imageCreator
    )
    {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
        $this->imageCreator = $imageCreator;
    }

    /**
     * @param array $data
     * @return Publication|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPublication(array $data): ?Publication
    {
        $data['user'] = $this->userService->findById($data['user']);

        $publication = $this->createPublicationEntity($data);

        if (array_key_exists('image', $data)) {
            $this->imageCreator->createImage(['name' => $data['image'], 'publication' => $publication]);
        }

        $this->entityManager->persist($publication);
        $this->entityManager->flush();

        return $publication;
    }

    private function createPublicationEntity($data): Publication
    {
        $publication =  new Publication();

        $publication->setDescription($data['description'] ?? null);
        $publication->setLongitude($data['longitude'] ?? null);
        $publication->setLatitude($data['latitude'] ?? null);
        $publication->setName($data['name'] ?? 'default');
        $publication->setUser($data['user'] ?? null);

        return $publication;
    }
}