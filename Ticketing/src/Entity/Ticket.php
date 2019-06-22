<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $journee;

    /**
     * @ORM\Column(type="integer")
     */
    private $demiJournee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Buyer", inversedBy="tickets")
     */
    private $buyer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reduction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJournee(): ?int
    {
        return $this->journee;
    }

    public function setJournee(int $journee): self
    {
        $this->journee = $journee;

        return $this;
    }

    public function getDemiJournee(): ?int
    {
        return $this->demiJournee;
    }

    public function setDemiJournee(int $demiJournee): self
    {
        $this->demiJournee = $demiJournee;

        return $this;
    }

    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }

    public function setBuyer(?Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getReduction(): ?bool
    {
        return $this->reduction;
    }

    public function setReduction(?bool $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }
}
