<?php

namespace Publication\Creator;

use Doctrine\ORM\EntityManager;
use Publication\Entity\Publication;
use Publication\Repository\PublicationRepository;
use User\Service\UserService;

class PublicationCreator
{
    /** @var UserService */
    private $userService;

    /** @var EntityManager */
    private $entityManager;

    /** @var ImageCreator */
    private $imageCreator;

    /** @var PublicationRepository */
    private $publicationRepository;

    public function __construct(
        UserService $userService,
        EntityManager $entityManager,
        ImageCreator $imageCreator,
        PublicationRepository $publicationRepository
    )
    {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
        $this->imageCreator = $imageCreator;
        $this->publicationRepository = $publicationRepository;
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

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deletePublication($id)
    {
        $publication = $this->publicationRepository->findById($id);

        if ($publication) {
            $this->entityManager->remove($publication);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @param $data
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updatePublication($id, $data)
    {
        $publication = $this->publicationRepository->findById($id);

        if ($publication) {
            $publication->setName($data['title']);
            $publication->setCategory($data['category']);
            $publication->setLatitude($data['latitude']);
            $publication->setLongitude($data['longitude']);
        }

        if (array_key_exists('image', $data) && $data['image']) {
            $img = $publication->getImages()->getValues()[0];
            $this->entityManager->remove($img);

            $this->imageCreator->createImage(['name' => $data['image'], 'publication' => $publication]);
        }

        $this->entityManager->persist($publication);
        $this->entityManager->flush();
    }

    private function createPublicationEntity($data): Publication
    {
        $publication =  new Publication();

        $publication->setDescription($data['description'] ?? null);
        $publication->setLongitude($data['longitude'] ?? null);
        $publication->setLatitude($data['latitude'] ?? null);
        $publication->setName($data['title'] ?? 'default');
        $publication->setUser($data['user'] ?? null);
        $publication->setCategory($data['category'] ?? 'veg');

        return $publication;
    }
}