<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuyerRepository")
 */
class Buyer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeTarif;

    /**
     * @ORM\Column(type="integer")
     */
    private $typeTicket;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrTickets;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeReservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
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

    public function getTypeTarif(): ?string
    {
        return $this->typeTarif;
    }

    public function setTypeTarif(string $typeTarif): self
    {
        $this->typeTarif = $typeTarif;

        return $this;
    }

    public function getTypeTicket(): ?int
    {
        return $this->typeTicket;
    }

    public function setTypeTicket(int $typeTicket): self
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    public function getNbrTickets(): ?int
    {
        return $this->nbrTickets;
    }

    public function setNbrTickets(int $nbrTickets): self
    {
        $this->nbrTickets = $nbrTickets;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getCodeReservation(): ?string
    {
        return $this->codeReservation;
    }

    public function setCodeReservation(string $codeReservation): self
    {
        $this->codeReservation = $codeReservation;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }
}
