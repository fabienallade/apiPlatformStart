<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read:house"}},
 *     denormalizationContext={"groups"={"write:house"}},
 *     itemOperations={
 *      "get",
 *      "put" ={"security"="is_granted('ROLE_USER') and object.user.owner==user"},
 *     "patch" ={"security"="is_granted('ROLE_USER') and object.user.owner==user"},
 *     "delete" = {"security"="is_granted('ROLE_USER') and object.user.owner==user"}
 *     },
 *     collectionOperations={
 *      "get",
 *     "post"={"security"="is_granted('ROLE_USER')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=HouseRepository::class)
 */
class House
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:house","write:house","read:user:item","read:review:item","read:reservation:item"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:house","write:house","read:user:item","read:review:item","read:reservation:item"})
     */
    private $descritption;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:house","write:house","read:review:item","read:user:item","read:reservation:item"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:house","write:house","read:user:item"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:house","write:house","read:user:item","read:review:item","read:reservation:item"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:house","write:house"})
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:house","write:house"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:house","write:house"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read:reservation:item"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="house")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="house")
     */
    private $reviews;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->reservations = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescritption(): ?string
    {
        return $this->descritption;
    }

    public function setDescritption(string $descritption): self
    {
        $this->descritption = $descritption;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHouse($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHouse() === $this) {
                $reservation->setHouse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setHouse($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getHouse() === $this) {
                $review->setHouse(null);
            }
        }

        return $this;
    }
}
