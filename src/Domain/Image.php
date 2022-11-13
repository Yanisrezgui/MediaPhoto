<?php

namespace App\Domain;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[Entity, Table(name: 'Image')]
final class Image
{
    #[Id, Column(name: 'id_img', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_img;

    #[Column(name: 'motcle', type: 'string', unique: false, nullable: false)]
    private string $motcle;

    #[Column(name: 'titre', type: 'string', unique: false, nullable: false)]
    private string $titre;

    #[Column(name: 'img_desc', type: 'text', unique: false, nullable: false)]
    private string $imgdesc;

    #[Column(name: 'img_name', type: 'string', unique: false, nullable: false)]
    private string $imgname;

    #[Column(name: 'img_mime', type: 'string', unique: false, nullable: false)]
    private string $imgmime;

    #[Column(name: 'img_data', type: 'blob', unique: false, nullable: false)]
    private mixed $imgdata;

    #[Column(name: 'date_crea', type: 'datetime', unique: false, nullable: false)]
    private DateTime $date_crea;

    #[ManyToOne(targetEntity: Galerie::class, inversedBy: 'galerie')]
    #[JoinColumn(name: 'id_galerie', referencedColumnName: 'id_galerie')]
    private $galerie;

    public function __construct(string $motcle, string $titre, string $imgdesc, string $imgname, string $imgmime, mixed $imgdata)
    {
        $this->motcle = $motcle;
        $this->titre = $titre;
        $this->imgdesc = $imgdesc;
        $this->imgname = $imgname;
        $this->imgmime = $imgmime;
        $this->imgdata = $imgdata;
        $this->date_crea = new DateTime();
    }

    public function getId_img(): int
    {
        return $this->id_img;
    }

    public function getMotCle(): string
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

    public function getImgName(): string
    {
        return $this->imgname;
    }

    public function getImgMime(): string
    {
        return $this->imgmime;
    }

    public function getImgData(): mixed
    {
        return $this->imgdata;
    }

    public function getDate(): DateTime
    {
        return $this->date_crea;
    }

    public function getDateString(DateTime $date): string
    {
        $newDate = $date->format('d/m/Y');
        return $newDate;
    }

    public function getBlobToString(): string
    {
        return base64_encode(stream_get_contents($this->getImgData()));
    }

    public function getGalerie(): ?Galerie
    {
        return $this->galerie;
    }

    public function setGalerie(?Galerie $galerie): self
    {
        $this->galerie = $galerie;
        return $this;
    }
}