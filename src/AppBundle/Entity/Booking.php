<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
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
     * @var int
     *
     * @ORM\Column(name="flight_id", type="integer")
     */
    private $flightId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="seat", type="string", length=255)
     */
    private $seat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set flightId.
     *
     * @param int $flightId
     *
     * @return Booking
     */
    public function setFlightId($flightId)
    {
        $this->flightId = $flightId;

        return $this;
    }

    /**
     * Get flightId.
     *
     * @return int
     */
    public function getFlightId()
    {
        return $this->flightId;
    }

    /**
     * Set userId.
     *
     * @param int $userId
     *
     * @return Booking
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set seat.
     *
     * @param string $seat
     *
     * @return Booking
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Get seat.
     *
     * @return string
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Booking
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Booking
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    

     /**
     * @ORM\PrePersist
     */
    public function setTimeStamp()
    {  
        $this->updatedAt = new \DateTime('now');

        if($this->createdAt == null){
            $this->createdAt = new \DateTime('now');
        }
    }
}
