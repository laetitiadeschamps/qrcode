<?php

namespace App\Entity;

use App\Repository\QrCodeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass=QrCodeRepository::class)
 */
class QrCode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:qrcodes"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:qrcodes"})
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:qrcodes"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:qrcodes"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:qrcodes"})
     */
    private $expires_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:qrcodes"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="qrCodes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:qrcodes"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="qrCodesShared")
     * @Groups({"read:qrcodes"})
     */
    private $shared_with;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:qrcodes"})
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:qrcodes"})
     */
    private $text;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read:qrcodes"})
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:qrcodes"})
     */
    private $background;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:qrcodes"})
     */
    private $foreground;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->shared_with = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expires_at;
    }

    public function setExpiresAt(?\DateTimeInterface $expires_at): self
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSharedWith(): Collection
    {
        return $this->shared_with;
    }

    public function addSharedWith(User $sharedWith): self
    {
        if (!$this->shared_with->contains($sharedWith)) {
            $this->shared_with[] = $sharedWith;
        }

        return $this;
    }

    public function removeSharedWith(User $sharedWith): self
    {
        $this->shared_with->removeElement($sharedWith);

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getForeground(): ?string
    {
        return $this->foreground;
    }

    public function setForeground(?string $foreground): self
    {
        $this->foreground = $foreground;

        return $this;
    }
}
