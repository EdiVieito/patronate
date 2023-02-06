<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Curso::class, inversedBy: 'users')]
    private Collection $CursosCostura;

    #[ORM\OneToOne(inversedBy: 'User', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medidas $Medidas = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Consultas::class, orphanRemoval: true)]
    private Collection $consultas;



    public function __construct($id = null,$email =null,$password = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->Medidas = new Medidas();
        $this->CursosCostura = new ArrayCollection();
        $this->consultas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMedidas(): ?Medidas
    {
        return $this->Medidas;
    }

    public function setMedidas(?Medidas $Medidas): self
    {
        $this->Medidas = $Medidas;

        return $this;
    }


    /**
     * @return Collection<int, Curso>
     */
    public function getCursosCostura(): Collection
    {
        return $this->CursosCostura;
    }

    public function addCursosCostura(Curso $cursosCostura): self
    {
        if (!$this->CursosCostura->contains($cursosCostura)) {
            $this->CursosCostura->add($cursosCostura);
        }

        return $this;
    }

    public function removeCursosCostura(Curso $cursosCostura): self
    {
        $this->CursosCostura->removeElement($cursosCostura);

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
            $consulta->setUser($this);
        }

        return $this;
    }

    public function removeConsulta(Consultas $consulta): self
    {
        if ($this->consultas->removeElement($consulta)) {
            // set the owning side to null (unless already changed)
            if ($consulta->getUser() === $this) {
                $consulta->setUser(null);
            }
        }

        return $this;
    }


}
