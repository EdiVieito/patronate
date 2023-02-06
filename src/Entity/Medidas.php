<?php

namespace App\Entity;

use App\Repository\MedidasRepository;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedidasRepository::class)]
class Medidas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $ancho_espalda = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $contorno_busto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $cintura = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $cadera = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $ancho_manga = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $largo_manga = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $contorno_punho = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $contorno_cuello = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $talle_delantero = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $talle_espalda = null;

    #[ORM\OneToOne(mappedBy: 'Medidas', cascade: ['persist', 'remove'])]
    private ?User $User;



    public function __construct($ancho_espalda = null,$contorno_busto = null,$cintura=null,$cadera=null,$ancho_manga=null,$largo_manga=null,$contorno_punho=null,$contorno_cuello=null,$talle_delantero=null,$talle_espalda=null)
    {
        $this->ancho_espalda =$ancho_espalda;
        $this->contorno_busto =$contorno_busto;
        $this->cintura= $cintura;
        $this->cadera = $cadera;
        $this->ancho_manga = $ancho_manga;
        $this->largo_manga = $largo_manga;
        $this->contorno_punho = $contorno_punho;
        $this->contorno_cuello = $contorno_cuello;
        $this->talle_delantero = $talle_delantero;
        $this->talle_espalda = $talle_espalda;

        //$this->interaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnchoEspalda(): ?string
    {
        return $this->ancho_espalda;
    }

    public function setAnchoEspalda(string $ancho_espalda): self
    {
        $this->ancho_espalda = $ancho_espalda;

        return $this;
    }

    public function getContornoBusto(): ?string
    {
        return $this->contorno_busto;
    }

    public function setContornoBusto(string $contorno_busto): self
    {
        $this->contorno_busto = $contorno_busto;

        return $this;
    }

    public function getCintura(): ?string
    {
        return $this->cintura;
    }

    public function setCintura(string $cintura): self
    {
        $this->cintura = $cintura;

        return $this;
    }

    public function getCadera(): ?string
    {
        return $this->cadera;
    }

    public function setCadera(string $cadera): self
    {
        $this->cadera = $cadera;

        return $this;
    }

    public function getAnchoManga(): ?string
    {
        return $this->ancho_manga;
    }

    public function setAnchoManga(string $ancho_manga): self
    {
        $this->ancho_manga = $ancho_manga;

        return $this;
    }

    public function getLargoManga(): ?string
    {
        return $this->largo_manga;
    }

    public function setLargoManga(string $largo_manga): self
    {
        $this->largo_manga = $largo_manga;

        return $this;
    }

    public function getContornoPunho(): ?string
    {
        return $this->contorno_punho;
    }

    public function setContornoPunho(string $contorno_punho): self
    {
        $this->contorno_punho = $contorno_punho;

        return $this;
    }

    public function getContornoCuello(): ?string
    {
        return $this->contorno_cuello;
    }

    public function setContornoCuello(string $contorno_cuello): self
    {
        $this->contorno_cuello = $contorno_cuello;

        return $this;
    }

    public function getTalleDelantero(): ?string
    {
        return $this->talle_delantero;
    }

    public function setTalleDelantero(string $talle_delantero): self
    {
        $this->talle_delantero = $talle_delantero;

        return $this;
    }

    public function getTalleEspalda(): ?string
    {
        return $this->talle_espalda;
    }

    public function setTalleEspalda(string $talle_espalda): self
    {
        $this->talle_espalda = $talle_espalda;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): self
    {
        // set the owning side of the relation if necessary
        if ($User->getMedidas() !== $this) {
            $User->setMedidas($this);
        }

        $this->User = $User;

        return $this;
    }

}
