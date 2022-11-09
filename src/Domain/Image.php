<?php

namespace App\Domain;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'Image')]
final class Image
{
    #[Id, Column(name: 'id_img', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_img;

    #[Column(name: 'motcle', type: 'string', unique: false, nullable: false)]
    private string $motcle;

    #[Column(name: 'titre', type: 'string', unique: false, nullable: false)]
    private string $titre;

    #[Column(name: 'img_desc', type: 'string', unique: false, nullable: false)]
    private string $imgdesc;

    #[Column(name: 'date_crea', type: 'datetimetz_immutable', unique: false, nullable: false)]
    private DateTimeImmutable $date_crea;

    #[Column(name: 'img_taille', type: 'string', unique: false, nullable: false)]
    private string $imgtaille;

    #[Column(name: 'img_blop', type: 'blob', unique: false, nullable: false)]
    private BlobType $imgblop;

    #[Column(name: 'img_type', type: 'string', unique: false, nullable: false)]
    private string $imgtype;

    #[OneToMany(targetEntity: Commentaire::class, mappedBy:'Image')]
    private $commentaires;
   


    public function __construct(string $motcle, string $titre, string $imgdesc,string $imgtaille,string $imgblop, string $imgtype)
    {
        $this->motcle = $motcle;
        $this->titre = $titre;
        $this->imgdesc = $imgdesc;
        $this->imgtaille= $imgtaille;
        $this->imgblop = $imgblop;
        $this->imgtype = $imgtype;
        $this->date = new DateTimeImmutable('now');
        $this->commentaires=new ArrayCollection();


    }
    public function getId_img(): int
    {
        return $this->id_img;
    }
    public function getmotcle(): string
    {
        return $this->motcle;
    }
    public function getTitre(): string
    {
        return $this->titre;
    }
    public function getImg_desc(): string
    {
        return $this->imgdesc;
    }
    public function getImg_taille(): string
    {
        return $this->imgtaille;
    }
    public function getImg_blop(): BlobType
    {
        return $this->imgblop;
    }
    public function getImg_type(): string
    {
        return $this->imgtype;
    }
    public function getDate(): DateTimeImmutable
    {
        return $this->date_crea;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }
    
}