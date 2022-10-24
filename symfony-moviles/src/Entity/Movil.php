<?php

namespace App\Entity;

use App\Repository\MovilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovilRepository::class)]
class Movil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * (message="El nombre es obligatorio")
     */
    private ?string $nombre = null;


    #[ORM\Column(length: 15)]
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * (message="La capacidad es obligatoria")
     */
    private ?string $capacidad = null;

    #[ORM\Column(length: 255)]
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * (message="La ram es obligatoria")
     */
    private ?string $ram = null;

    #[ORM\Column(length: 255)]
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * (message="El precioo es obligatorio")
     */
    private ?string $precio = null;

    #[ORM\ManyToOne]
    private ?Marca $marca = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCapacidad(): ?string
    {
        return $this->capacidad;
    }

    public function setCapacidad(string $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getRam(): ?string
    {
        return $this->ram;
    }

    public function setRam(string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }
}
