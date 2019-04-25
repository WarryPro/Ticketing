<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $normal;

    /**
     * @ORM\Column(type="float")
     */
    private $enfant;

    /**
     * @ORM\Column(type="float")
     */
    private $senior;

    /**
     * @ORM\Column(type="float")
     */
    private $reduit;

    /**
     * @ORM\Column(type="float")
     */
    private $gratuit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNormal(): ?float
    {
        return $this->normal;
    }

    public function setNormal(float $normal): self
    {
        $this->normal = $normal;

        return $this;
    }

    public function getEnfant(): ?float
    {
        return $this->enfant;
    }

    public function setEnfant(float $enfant): self
    {
        $this->enfant = $enfant;

        return $this;
    }

    public function getSenior(): ?float
    {
        return $this->senior;
    }

    public function setSenior(float $senior): self
    {
        $this->senior = $senior;

        return $this;
    }

    public function getReduit(): ?float
    {
        return $this->reduit;
    }

    public function setReduit(float $reduit): self
    {
        $this->reduit = $reduit;

        return $this;
    }

    public function getGratuit(): ?float
    {
        return $this->gratuit;
    }

    public function setGratuit(float $gratuit): self
    {
        $this->gratuit = $gratuit;

        return $this;
    }
}
