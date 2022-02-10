<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingsRepository::class)
 */
class Bookings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $roomid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $datefrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberofpeople;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomid(): ?int
    {
        return $this->roomid;
    }

    public function setRoomid(int $roomid): self
    {
        $this->roomid = $roomid;

        return $this;
    }

    public function getDatefrom(): ?string
    {
        return $this->datefrom;
    }

    public function setDatefrom(string $datefrom): self
    {
        $this->datefrom = $datefrom;

        return $this;
    }

    public function getDateto(): ?string
    {
        return $this->dateto;
    }

    public function setDateto(string $dateto): self
    {
        $this->dateto = $dateto;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNumberofpeople(): ?string
    {
        return $this->numberofpeople;
    }

    public function setNumberofpeople(string $numberofpeople): self
    {
        $this->numberofpeople = $numberofpeople;

        return $this;
    }
}
