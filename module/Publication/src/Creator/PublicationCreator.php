<?php

namespace Publication\Creator;

use Doctrine\ORM\EntityManager;
use Publication\Entity\Publication;
use Publication\Repository\CategoryRepository;
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

    /** @var LocationCreator */
    private $locationCreator;

    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(
        UserService $userService,
        EntityManager $entityManager,
        ImageCreator $imageCreator,
        PublicationRepository $publicationRepository,
        LocationCreator $locationCreator,
        CategoryRepository $categoryRepository
    )
    {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
        $this->imageCreator = $imageCreator;
        $this->publicationRepository = $publicationRepository;
        $this->locationCreator = $locationCreator;
        $this->categoryRepository = $categoryRepository;
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
        $location = $this->locationCreator->createImage(['latitude' => $data['latitude'], 'longitude' => $data['longitude']]);
        $category = $this->categoryRepository->findByName($data['category']);

        $location->setPublication($publication);
        $this->entityManager->persist($location);
        $publication->setCategory($category);

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
            $this->entityManager->remove($publication->getLocation());
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
            $publication->setDescription($data['description']);
            $publication->setCategory($this->categoryRepository->findByName($data['category']));

            $location = $publication->getLocation();
            $location->setLatitude($data['latitude']);
            $location->setLongitude($data['longitude']);
        }

        if (array_key_exists('image', $data) && $data['image']) {
            $img = $publication->getImages()->getValues()[0];
            $this->entityManager->remove($img);

            $this->imageCreator->createImage(['name' => $data['image'], 'publication' => $publication]);
        }

        $this->entityManager->persist($publication->getLocation());
        $this->entityManager->persist($publication);
        $this->entityManager->flush();
    }

    private function createPublicationEntity($data): Publication
    {
        $publication =  new Publication();

        $publication->setDescription($data['description'] ?? null);
        $publication->setName($data['title'] ?? 'default');
        $publication->setUser($data['user'] ?? null);

        return $publication;
    }
}