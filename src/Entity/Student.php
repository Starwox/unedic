<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $LastName;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *     max = 10,
     *     maxMessage = "Max 10 digits"
     * )
     */
    private $NumEtud;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="student")
     */
    private $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getNumEtud(): ?int
    {
        return $this->NumEtud;
    }

    public function setNumEtud(int $NumEtud): self
    {
        $this->NumEtud = $NumEtud;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
