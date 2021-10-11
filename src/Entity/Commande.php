<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="commandes")
     */
    private $address;

    

    /**
     * @ORM\OneToOne(targetEntity=Payement::class, cascade={"persist", "remove"})

     */
    private $payement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Payement::class, mappedBy="commande", cascade={"persist", "remove"})
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getAddress(): ?adresse
    {
        return $this->address;
    }

    public function setAddress(?adresse $address): self
    {
        $this->address = $address;

        return $this;
    }



    public function getPayement(): ?Payement
    {
        return $this->payement;
    }

    public function setPayement(Payement $payement): self
    {
        $this->payement = $payement;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCommande(): ?Payement
    {
        return $this->commande;
    }

    public function setCommande(Payement $commande): self
    {
        // set the owning side of the relation if necessary
        if ($commande->getCommande() !== $this) {
            $commande->setCommande($this);
        }

        $this->commande = $commande;

        return $this;
    }
}
