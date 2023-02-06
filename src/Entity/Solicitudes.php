<?php

namespace App\Entity;

use App\Repository\SolicitudesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolicitudesRepository::class)]
class Solicitudes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $User = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column]
    private ?int $Curso = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->User;
    }

    public function setUser(int $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): self
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getCurso(): ?int
    {
        return $this->Curso;
    }

    public function setCurso(int $Curso): self
    {
        $this->Curso = $Curso;

        return $this;
    }
}
