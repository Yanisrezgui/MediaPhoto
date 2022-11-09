<?php

namespace App\Domain;

use DateTimeImmutable;
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
use Doctrine\ORM\Mapping\OneToMany;

#[Entity, Table(name: 'Galerie')]
final class Galerie
{
    #[Id, Column(name: 'id_galerie', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'accesibilité', type: 'boolean', nullable: false)]
    private bool $acces;

    #[Column(name: 'Titre', type: 'string', nullable: false)]
    private string $titre;

    #[Column(name: 'descr', type: 'string', nullable: true)]
    private string $description;

    #[Column(name: 'date_crea', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $date;

    #[Column(name: 'mot_clé', type: 'string', nullable: false)]
    private string $motcle;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'galeries')]
    private $user;
    

    public function __construct(bool $acces, string $titre, string $description, string $motcle)
    {
        $this->acces = $acces;
        $this->titre = $titre;
        $this->description = $description;
        $this->date = new DateTimeImmutable('now');
        $this->motcle = $motcle;
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getAcces(): bool
    {
        return $this->acces;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getMotCle(): string
    {
        return $this->motcle;
    }

    public function getuser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}