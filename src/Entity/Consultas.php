<?php

namespace App\Entity;

use App\Repository\ConsultasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultasRepository::class)]
class Consultas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pregunta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Respuesta = null;


    #[ORM\ManyToOne(inversedBy: 'consultas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Curso $curso = null;

    #[ORM\ManyToOne(inversedBy: 'consultas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPregunta(): ?string
    {
        return $this->pregunta;
    }

    public function setPregunta(?string $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getRespuesta(): ?string
    {
        return $this->Respuesta;
    }

    public function setRespuesta(?string $Respuesta): self
    {
        $this->Respuesta = $Respuesta;

        return $this;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
