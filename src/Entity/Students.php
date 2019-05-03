<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentsRepository")
 */
class Students
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $average_mark;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAverageMark(): ?float
    {
        return $this->average_mark;
    }

    public function setAverageMark(float $average_mark): self
    {
        $this->average_mark = $average_mark;

        return $this;
    }
}
