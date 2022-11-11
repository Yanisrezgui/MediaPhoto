<?php

namespace App\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
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

    #[Column(name: 'img_desc', type: 'text', unique: false, nullable: false)]
    private string $imgdesc;

    #[Column(name: 'date_crea', type: 'datetimetz_immutable', unique: false, nullable: false)]
    private DateTimeImmutable $date_crea;

    #[Column(name: 'img_name', type: 'string', unique: false, nullable: false)]
    private string $imgname;

    public function __construct(string $motcle, string $titre, string $imgdesc, string $imgname)
    {
        $this->motcle = $motcle;
        $this->titre = $titre;
        $this->imgdesc = $imgdesc;
        $this->imgname= $imgname;
        $this->date_crea = new DateTimeImmutable('now');
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

    public function getDate(): DateTimeImmutable
    {
        return $this->date_crea;
    }
}