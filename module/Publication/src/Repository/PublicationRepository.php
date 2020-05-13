<?php

namespace Publication\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Publication\Entity\Publication;
use Publication\Shared\HierarchyArrayHydrator;

class PublicationRepository extends EntityRepository
{
    /**
     * @param string $email
     * @param string $password
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByUsernameAndPassword(string $email, string $password)
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->andWhere('u.password = :password')
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllAsArray($user = null, $category = null)
    {
        $query = $this->createQueryBuilder('p')
            ->select()
            ->addSelect('im')
            ->addSelect('us')
            ->leftJoin('p.images', 'im')
            ->leftJoin('p.user', 'us');

        if ($user) {
            $query->andWhere("p.user = :user")
                ->setParameter('user', $user);
        }

        if ($category) {
            $query->andWhere("p.category = :category")
                ->setParameter('category', $category);
        }

        return $query->getQuery()->getResult(HierarchyArrayHydrator::class);
    }

    public function findByIdAsArray(int $id)
    {
        return $this->createQueryBuilder('p')
            ->select()
            ->addSelect('im')
            ->addSelect('us')
            ->leftJoin('p.images', 'im')
            ->leftJoin('p.user', 'us')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(HierarchyArrayHydrator::class);
    }

    /**
     * @param $id
     * @return Publication|null
     * @throws NonUniqueResultException
     */
    public function findById($id): ?Publication
    {
        return $this->createQueryBuilder('p')
            ->select()
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}