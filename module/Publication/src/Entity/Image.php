<?php

namespace Publication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Publication\Repository\ImageRepository")
 * @ORM\Table(name="images")
 */
class Image
{
    /**
     * @ORM\Id
     * @var int
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="i_id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Publication\Entity\Publication", cascade={"persist"})
     * @ORM\JoinColumn(name="i_p_id", referencedColumnName="p_id")
     */
    private $publication;

    /**
     * @var string
     * @ORM\Column(type="string", name="i_name")
     */
    private $name;

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
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication): void
    {
        $this->publication = $publication;
    }


}