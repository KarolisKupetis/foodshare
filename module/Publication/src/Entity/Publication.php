<?php

namespace Publication\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Publication\Repository\PublicationRepository")
 * @ORM\Table(name="publications")
 */
class Publication
{
    public function __construct() {
        $this->images = new ArrayCollection();
    }

    public const PUBLICATION_ACTIVE = 'active';
    public const PUBLICATION_TAKEN = 'taken';
    public const PUBLICATION_EXPIRED = 'expired';

    public const PUBLICATION_STATUSES = [
        self::PUBLICATION_ACTIVE,
        self::PUBLICATION_TAKEN,
        self::PUBLICATION_EXPIRED
    ];

    /**
     * @ORM\Id
     * @var int
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="p_id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * One publication has one user
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="p_u_id", referencedColumnName="u_id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", name="p_title")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", name="p_status")
     */
    private $status = self::PUBLICATION_ACTIVE;

    /**
     * @var string
     * @ORM\Column(type="string", name="p_description")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", name="p_latitude")
     */
    private $latitude;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Image", mappedBy="publication")
     */
    private $images;

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @var string
     * @ORM\Column(type="string", name="p_longitude")
     */
    private $longitude;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }
}