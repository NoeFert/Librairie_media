<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $role = null;

    /**
     * @var Collection<int, Publication>
     */
    #[ORM\ManyToMany(targetEntity: Publication::class, mappedBy: 'auteur')]
    private Collection $publications;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $portait_url = null;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->addAuteur($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            $publication->removeAuteur($this);
        }

        return $this;
    }

    public function getPortaitUrl(): ?string
    {
        return $this->portait_url;
    }

    public function setPortaitUrl(?string $portait_url): static
    {
        $this->portait_url = $portait_url;

        return $this;
    }
}
