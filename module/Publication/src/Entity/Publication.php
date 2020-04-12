<?php

namespace Publication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Publication\Repository\PublicationRepository")
 * @ORM\Table(name="publications")
 */
class Publication
{
    /**
     * @ORM\Id
     * @var int
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * One publication has one user
     * @ORM\OneToOne(targetEntity="Mytest\Entity\User")
     * @ORM\JoinColumn(name="u_id", referencedColumnName="p_u_id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name="p_title")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name="p_status")
     */
    private $status;

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
}