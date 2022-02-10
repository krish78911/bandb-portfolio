<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomsRepository::class)
 */
class Rooms
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roomtype;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxpeople;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $availability;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $checkin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $checkout;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $privatebathroom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomtype(): ?string
    {
        return $this->roomtype;
    }

    public function setRoomtype(string $roomtype): self
    {
        $this->roomtype = $roomtype;

        return $this;
    }

    public function getMaxpeople(): ?int
    {
        return $this->maxpeople;
    }

    public function setMaxpeople(int $maxpeople): self
    {
        $this->maxpeople = $maxpeople;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getCheckin(): ?string
    {
        return $this->checkin;
    }

    public function setCheckin(string $checkin): self
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckout(): ?string
    {
        return $this->checkout;
    }

    public function setCheckout(string $checkout): self
    {
        $this->checkout = $checkout;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrivatebathroom(): ?string
    {
        return $this->privatebathroom;
    }

    public function setPrivatebathroom(string $privatebathroom): self
    {
        $this->privatebathroom = $privatebathroom;

        return $this;
    }
}
