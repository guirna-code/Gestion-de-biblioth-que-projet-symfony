<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column(length: 10)]
    private ?string $livre = null;

    #[ORM\Column]
    private ?\DateTime $Empruntdate = null;

    #[ORM\Column]
    private ?\DateTime $dateretour = null;

    #[ORM\Column(name:"dateretourreel", nullable: true)]
    private ?\DateTime $dateretourreel = null;

    #[ORM\Column(nullable: true, name: "penalites")]
    private ?float $penalites = null;

    public function getId(): ?int
    { 
        return $this->id;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getLivre(): ?string
    {
        return $this->livre;
    }

    public function setLivre(string $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getEmpruntdate(): ?\DateTime
    {
        return $this->Empruntdate;
    }

    public function setEmpruntdate(\DateTime $Empruntdate): static
    {
        $this->Empruntdate = $Empruntdate;

        return $this;
    }

    public function getDateretour(): ?\DateTime
    {
        return $this->dateretour;
    }

    public function setDateretour(\DateTime $dateretour): static
    {
        $this->dateretour = $dateretour;

        return $this;
    }

    public function getDateRetourReelle(): ?\DateTime
    {
        return $this->dateretourreel;
    }

    public function setDateRetourReelle(?\DateTime $dateretourreel): static
    {
        $this->dateretourreel = $dateretourreel;

        return $this;
    }

    // Backwards-compatible aliases: some code accesses the property as "dateretourreel"
    // PropertyAccessor expects getDateretourreel()/setDateretourreel(). Provide aliases.
    public function getDateretourreel(): ?\DateTime
    {
        return $this->getDateRetourReelle();
    }

    public function setDateretourreel(?\DateTime $dateretourreel): static
    {
        return $this->setDateRetourReelle($dateretourreel);
    }

    public function getPenalites(): ?float
    {
        return $this->penalites;
    }

    public function setPenalites(?float $penalites): static
    {
        $this->penalites = $penalites;

        return $this;
    }
}
