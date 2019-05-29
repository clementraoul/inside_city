<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CircuitRepository")
 */
class Circuit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="act1", type="string", length=255)
     */
    private $act1;

    /**
     * @var string
     *
     * @ORM\Column(name="act2", type="string", length=255, nullable=true)
     */
    private $act2;

    /**
     * @var string
     *
     * @ORM\Column(name="act3", type="string", length=255, nullable=true)
     */
    private $act3;

    /**
     * @var string
     *
     * @ORM\Column(name="act4", type="string", length=255, nullable=true)
     */
    private $act4;

    /**
     * @var string
     *
     * @ORM\Column(name="act5", type="string", length=255, nullable=true)
     */
    private $act5;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="string", length=255)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     * 
     * @ORM\Column(name="document", type="string", length=255)
     */
    private $document;

    /**
     * Many circuit have one city. This is the owning side.
     * @ORM\ManyToOne(targetEntity="City", inversedBy="circuits")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $cities;
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Circuit
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Circuit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set act1
     *
     * @param string $act1
     *
     * @return Circuit
     */
    public function setAct1($act1)
    {
        $this->act1 = $act1;

        return $this;
    }

    /**
     * Get act1
     *
     * @return string
     */
    public function getAct1()
    {
        return $this->act1;
    }

    /**
     * Set act2
     *
     * @param string $act2
     *
     * @return Circuit
     */
    public function setAct2($act2)
    {
        $this->act2 = $act2;

        return $this;
    }

    /**
     * Get act2
     *
     * @return string
     */
    public function getAct2()
    {
        return $this->act2;
    }

    /**
     * Set act3
     *
     * @param string $act3
     *
     * @return Circuit
     */
    public function setAct3($act3)
    {
        $this->act3 = $act3;

        return $this;
    }

    /**
     * Get act3
     *
     * @return string
     */
    public function getAct3()
    {
        return $this->act3;
    }

    /**
     * Set act4
     *
     * @param string $act4
     *
     * @return Circuit
     */
    public function setAct4($act4)
    {
        $this->act4 = $act4;

        return $this;
    }

    /**
     * Get act4
     *
     * @return string
     */
    public function getAct4()
    {
        return $this->act4;
    }

    /**
     * Set act5
     *
     * @param string $act5
     *
     * @return Circuit
     */
    public function setAct5($act5)
    {
        $this->act5 = $act5;

        return $this;
    }

    /**
     * Get act5
     *
     * @return string
     */
    public function getAct5()
    {
        return $this->act5;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Circuit
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set distance
     *
     * @param string $distance
     *
     * @return Circuit
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return string
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Circuit
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set document
     *
     * @param string $document
     *
     * @return Circuit
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set cities
     *
     * @param \AppBundle\Entity\City $cities
     *
     * @return Circuit
     */
    public function setCities(\AppBundle\Entity\City $cities = null)
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * Get cities
     *
     * @return \AppBundle\Entity\City
     */
    public function getCities()
    {
        return $this->cities;
    }
}
