<?php

namespace Publication\Service;

use Publication\Creator\PublicationCreator;
use Publication\Repository\PublicationRepository;

class PublicationsService
{
    /** @var PublicationRepository */
    private $repository;

    /** @var PublicationCreator */
    private $creator;

    public function __construct(PublicationRepository $repository, PublicationCreator $creator)
    {
        $this->repository = $repository;
        $this->creator = $creator;
    }

    /**
     * @param string|null $latitude
     * @param string|null $longitude
     * @param null $user
     * @param null $category
     * @return array
     */
    public function findAllAsArray(string $latitude = null, string $longitude = null, $user = null, $category = null): array
    {
       $publications = $this->repository->findAllAsArray($user, $category);

       if ($longitude && $latitude) {
           foreach ($publications as $key => $single) {
               $publications[$key]['distance'] = $this->getDistance(
                   $latitude,
                   $longitude,
                   $single['location']['latitude'],
                   $single['location']['longitude'],
                   'K'
               );
           }

           usort($publications, function ($a, $b){
              return $a['distance'] <=> $b['distance'];
           });
       }

       return $publications;
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPublication($data): void
    {
        $this->creator->createPublication($data);
    }

    public function deletePublication($id)
    {
        return $this->creator->deletePublication($id);
    }

    public function updateById($id, $data)
    {
        $this->creator->updatePublication($id, $data);
    }

    /**
     * @param int $id
     * @return array[]
     */
    public function findByIdAsArray(int $id): array
    {
        return $this->repository->findByIdAsArray($id);
    }

    private function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 === $lat2) && ($lon1 === $lon2)) {
            return 0;
        }

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === "K") {
            return round(($miles * 1.609344), 2);
        }

        if ($unit === "N") {
            return ($miles * 0.8684);
        }

        return $miles;
    }

}