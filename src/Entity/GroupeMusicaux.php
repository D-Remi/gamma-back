<?php

namespace App\Entity;

use App\Repository\GroupeMusicauxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeMusicauxRepository::class)]
class GroupeMusicaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $origine = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $annee_debut = null;

    #[ORM\Column(nullable: true)]
    private ?int $anne_separation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fondateurs = null;

    #[ORM\Column]
    private ?int $membres = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $courant_musical = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): static
    {
        $this->origine = $origine;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAnneeDebut(): ?int
    {
        return $this->annee_debut;
    }

    public function setAnneeDebut(int $annee_debut): static
    {
        $this->annee_debut = $annee_debut;

        return $this;
    }

    public function getAnneSeparation(): ?int
    {
        return $this->anne_separation;
    }

    public function setAnneSeparation(?int $anne_separation): static
    {
        $this->anne_separation = $anne_separation;

        return $this;
    }

    public function getFondateurs(): ?string
    {
        return $this->fondateurs;
    }

    public function setFondateurs(?string $fondateurs): static
    {
        $this->fondateurs = $fondateurs;

        return $this;
    }

    public function getMembres(): ?int
    {
        return $this->membres;
    }

    public function setMembres(int $membres): static
    {
        $this->membres = $membres;

        return $this;
    }

    public function getCourantMusical(): ?string
    {
        return $this->courant_musical;
    }

    public function setCourantMusical(?string $courant_musical): static
    {
        $this->courant_musical = $courant_musical;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }
}
