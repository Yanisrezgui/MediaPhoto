<?php

namespace App\Domain;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\InverseJoinColumn;

#[Entity, Table(name: 'Galerie')]
class Galerie
{
    #[Id, Column(name: 'id_galerie', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'access', type: 'boolean', nullable: false)]
    private bool $acces;

    #[Column(name: 'Titre', type: 'string', nullable: false)]
    private string $titre;

    #[Column(name: 'descr', type: 'string', nullable: true)]
    private string $description;

    #[Column(name: 'date_crea', type: 'datetime', nullable: false)]
    private DateTime $date;

    #[Column(name: 'keyword', type: 'string', nullable: false)]
    private string $motcle;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'galeries')]
    #[JoinColumn(name: 'id_util', referencedColumnName: 'id_util')]
    private $user;

    #[JoinTable(name: 'Acces_Galerie')]
    #[JoinColumn(name: 'id_galerie', referencedColumnName: 'id_galerie')]
    #[InverseJoinColumn(name: 'id_util', referencedColumnName: 'id_util')]
    #[ManyToMany(targetEntity: User::class)]
    private Collection $user_acces;

    #[JoinTable(name: 'PhotoGalerie')]
    #[JoinColumn(name: 'id_galerie', referencedColumnName: 'id_galerie')]
    #[InverseJoinColumn(name: 'id_img', referencedColumnName: 'id_img')]
    #[ManyToMany(targetEntity: Image::class)]
    private Collection $imageGalery;

    public function __construct(bool $acces, string $titre, string $description, string $motcle)
    {
        $this->acces = $acces;
        $this->titre = $titre;
        $this->description = $description;
        $this->date = new DateTime();
        $this->motcle = $motcle;
        $this->user_acces = new ArrayCollection();
        $this->imageGalery = new ArrayCollection();
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getAcces(): bool
    {
        return $this->acces;
    }

    public function setAcces(bool $acces): bool
    {
        $this->acces = $acces;
        return $acces;
    }

    public function getAccesString(bool $acces): string
    {
        if($acces) {
            return 'Public';
        } else {
            return 'Privé';
        }
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): string
    {
        $this->titre = $titre;
        return $titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): string
    {
        $this->description = $description;
        return $description;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getDateString(DateTime $date): string
    {
        $newDate = $date->format('d/m/Y');
        return $newDate;

    }

    public function getMotCle(): string
    {
        return $this->motcle;
    }

    public function setMotCle(string $motcle): string
    {
        $this->motcle = $motcle;
        return $motcle;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUserAcces(): Collection
    {
        return $this->user_acces;
    }

    public function addUserAcces(?User $user): Collection
    {
        if(!$this->user_acces->contains($user)) {
            $this->user_acces[] = $user;
        }
        return $this->user_acces;
    }

    public function setImageGalerie(?Image $imageGalery): self
    {
        $this->user = $imageGalery;
        return $this;
    }

    public function getImageGalerie(): Collection
    {
        return $this->imageGalery;
    }
}