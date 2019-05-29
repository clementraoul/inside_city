<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, unique=true)
     */
    private $image;

     /**
     * Many destination have one city. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Destination", inversedBy="cities")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id")
     */
    private $destinations;

    /**
     * One city has many circuit. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Circuit", mappedBy="cities")
     */
    private $circuits;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->circuits = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return City
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set destinations
     *
     * @param \AppBundle\Entity\Destination $destinations
     *
     * @return City
     */
    public function setDestinations(\AppBundle\Entity\Destination $destinations = null)
    {
        $this->destinations = $destinations;

        return $this;
    }

    /**
     * Get destinations
     *
     * @return \AppBundle\Entity\Destination
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Add circuit
     *
     * @param \AppBundle\Entity\Circuit $circuit
     *
     * @return City
     */
    public function addCircuit(\AppBundle\Entity\Circuit $circuit)
    {
        $this->circuits[] = $circuit;

        return $this;
    }

    /**
     * Remove circuit
     *
     * @param \AppBundle\Entity\Circuit $circuit
     */
    public function removeCircuit(\AppBundle\Entity\Circuit $circuit)
    {
        $this->circuits->removeElement($circuit);
    }

    /**
     * Get circuits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCircuits()
    {
        return $this->circuits;
    }
}
