<?php

namespace App\Entity;

use App\Entity\Medidas;
use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dificultad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_prenda = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'CursosCostura')]
    private Collection $users;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ud1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ud2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ud3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ud4 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ud5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video5 = null;

    #[ORM\OneToMany(mappedBy: 'curso', targetEntity: Consultas::class, orphanRemoval: true)]
    private Collection $consultas;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->consultas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDificultad(): ?string
    {
        return $this->dificultad;
    }

    public function setDificultad(?string $dificultad): self
    {
        $this->dificultad = $dificultad;

        return $this;
    }

    public function getTipoPrenda(): ?string
    {
        return $this->tipo_prenda;
    }

    public function setTipoPrenda(?string $tipo_prenda): self
    {
        $this->tipo_prenda = $tipo_prenda;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCursosCostura($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCursosCostura($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->titulo;
    }

    public function getUd1(): ?string
    {
        return $this->ud1;
    }

    public function setUd1(?string $ud1): self
    {
        $this->ud1 = $ud1;

        return $this;
    }

    public function getUd2(): ?string
    {
        return $this->ud2;
    }

    public function setUd2(?string $ud2): self
    {
        $this->ud2 = $ud2;

        return $this;
    }

    public function getUd3(): ?string
    {
        return $this->ud3;
    }

    public function setUd3(?string $ud3): self
    {
        $this->ud3 = $ud3;

        return $this;
    }

    public function getUd4(): ?string
    {
        return $this->ud4;
    }

    public function setUd4(?string $ud4): self
    {
        $this->ud4 = $ud4;

        return $this;
    }

    public function getUd5(): ?string
    {
        return $this->ud5;
    }

    public function setUd5(?string $ud5): self
    {
        $this->ud5 = $ud5;

        return $this;
    }

    public function getVideo1(): ?string
    {
        return $this->video1;
    }

    public function setVideo1(?string $video1): self
    {
        $this->video1 = $video1;

        return $this;
    }

    public function getVideo2(): ?string
    {
        return $this->video2;
    }

    public function setVideo2(?string $video2): self
    {
        $this->video2 = $video2;

        return $this;
    }

    public function getVideo3(): ?string
    {
        return $this->video3;
    }

    public function setVideo3(?string $video3): self
    {
        $this->video3 = $video3;

        return $this;
    }

    public function getVideo4(): ?string
    {
        return $this->video4;
    }

    public function setVideo4(?string $video4): self
    {
        $this->video4 = $video4;

        return $this;
    }

    public function getVideo5(): ?string
    {
        return $this->video5;
    }

    public function setVideo5(?string $video5): self
    {
        $this->video5 = $video5;

        return $this;
    }

    /**
     * @return Collection<int, Consultas>
     */
    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function addConsulta(Consultas $consulta): self
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas->add($consulta);
            $consulta->setCurso($this);
        }

        return $this;
    }

    public function removeConsulta(Consultas $consulta): self
    {
        if ($this->consultas->removeElement($consulta)) {
            // set the owning side to null (unless already changed)
            if ($consulta->getCurso() === $this) {
                $consulta->setCurso(null);
            }
        }

        return $this;
    }

}
