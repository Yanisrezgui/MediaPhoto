<?php

namespace App\Domain;

use DateTimeImmutable;
use Doctrine\DBAL\Types\BlobType;
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

    #[Column(name: 'img_desc', type: 'string', unique: false, nullable: false)]
    private string $imgdesc;

    #[Column(name: 'date_crea', type: 'datetimetz_immutable', unique: false, nullable: false)]
    private DateTimeImmutable $date_crea;

    #[Column(name: 'img_name', type: 'string', unique: false, nullable: false)]
    private string $imgname;

    #[Column(name: 'img_mime', type: 'string', unique: false, nullable: false)]
    private string $imgmime;

    #[Column(name: 'img_blob', type: 'blob', unique: false, nullable: false)]
    private BlobType $imgblob;


    public function __construct(string $motcle, string $titre, string $imgdesc, string $imgname, string $imgmime, BlobType $imgblob)
    {
        $this->motcle = $motcle;
        $this->titre = $titre;
        $this->imgdesc = $imgdesc;
        $this->imgname= $imgname;
        $this->imgmime = $imgmime;
        $this->imgblob = $imgblob;
        $this->date = new DateTimeImmutable('now');
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

    public function getimgname(): string
    {
        return $this->imgname;
    }

    public function getimgmime(): string
    {
        return $this->imgmime;
    }

    public function getImg_blob(): BlobType
    {
        return $this->imgblob;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date_crea;
    }

   
}