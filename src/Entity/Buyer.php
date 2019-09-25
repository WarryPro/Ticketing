<?php

namespace App\Entity;

use App\Validator\NbreTickets;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\CloseDay;

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
     * @Assert\Email(
     *     message = "The email '{{ value }}' Le email n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeTarif;


    /**
     * @ORM\Column(type="integer")
     * @NbreTickets()
     */
    private $nbrTickets;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today UTC", message="Vous ne pouvez pas réservez pour les jours passés")
     * @CloseDay()
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="buyer", cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="float")
     */
    private $Total;


    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->dateReservation = new \DateTime();
        $this->codeReservation = substr(sha1(random_bytes(10)), 0, 10);
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

    public function getTypeTarif(): ?string
    {
        return $this->typeTarif;
    }

    public function setTypeTarif(string $typeTarif): self
    {
        $this->typeTarif = $typeTarif;

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

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setBuyer($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getBuyer() === $this) {
                $ticket->setBuyer(null);
            }
        }

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->Total;
    }

    public function setTotal(float $Total): self
    {
        $this->Total = $Total;

        return $this;
    }
}
