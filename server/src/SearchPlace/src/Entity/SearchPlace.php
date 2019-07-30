<?php

declare(strict_types=1);

namespace SearchPlace\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="placesDB")
 **/
class SearchPlace
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $placeID;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $placename;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $lati;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $longi;

    /**
     * @ORM\Column(type="string")
     */
    protected $vicinity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photos;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rating;

    /**
     * @param array $requestBody
     */
    public function setPlaceToDatabase(array $requestBody): void
    {
        $this->setPlaceID($requestBody['placeID']);
        $this->setName($requestBody['name']);
        $this->setLatitude($requestBody['lati']);
        $this->setLongtitude($requestBody['longi']);
        $this->setVicinity($requestBody['vicinity']);
        $this->setRating($requestBody['rating']);

        if (isset($requestBody['photos']))
        {
            $this->setPhotos($requestBody['photos']);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $area
     */
    public function setPlaceID(string $placeID): void
    {
        $this->placeID = $placeID;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->placename = $name;
    }

    /**
     * @param string $lati
     */
    public function setLatitude(string $lati): void
    {
        $this->lati = $lati;
    }

    /**
     * @param string $longi
     */
    public function setLongtitude(string $longi): void
    {
        $this->longi = $longi;
    }

    /**
     * @param string $vicinity
     */
    public function setVicinity(string $vicinity): void
    {
        $this->vicinity = $vicinity;
    }

    /**
     * @param string $photos
     */
    public function setPhotos(string $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

}