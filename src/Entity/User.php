<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator as CustomValidator;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="Ce mail est déjà utilisé")
 * @CustomValidator\RepeatPassword()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:qrcodes"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'email ne peut pas être vide.")
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide."
     * )
     * @Groups({"read:qrcodes"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank(message="Le mot de passe ne peut pas être vide.")
     * @Assert\Regex(
     *      pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$%_*|=&-])[A-Za-z\d@$%_*|=&-]{6,}$/",
     *      message="Le mot de passe doit faire au moins 6 caractères, comporter une majuscule, une minuscule, un chiffre et un caractère spécial parmi les suivants : @$%_*|=-"
     *  )
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=QrCode::class, mappedBy="author")
     */
    private $qrCodes;

    /**
     * @ORM\ManyToMany(targetEntity=QrCode::class, mappedBy="shared_with")
     */
    private $qrCodesShared;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password_confirm;

    public function __construct()
    {
        $this->qrCodes = new ArrayCollection();
        $this->qrCodesShared = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|QrCode[]
     */
    public function getQrCodes(): Collection
    {
        return $this->qrCodes;
    }

    public function addQrCode(QrCode $qrCode): self
    {
        if (!$this->qrCodes->contains($qrCode)) {
            $this->qrCodes[] = $qrCode;
            $qrCode->setAuthor($this);
        }

        return $this;
    }

    public function removeQrCode(QrCode $qrCode): self
    {
        if ($this->qrCodes->removeElement($qrCode)) {
            // set the owning side to null (unless already changed)
            if ($qrCode->getAuthor() === $this) {
                $qrCode->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QrCode[]
     */
    public function getQrCodesShared(): Collection
    {
        return $this->qrCodesShared;
    }

    public function addQrCodesShared(QrCode $qrCodesShared): self
    {
        if (!$this->qrCodesShared->contains($qrCodesShared)) {
            $this->qrCodesShared[] = $qrCodesShared;
            $qrCodesShared->addSharedWith($this);
        }

        return $this;
    }

    public function removeQrCodesShared(QrCode $qrCodesShared): self
    {
        if ($this->qrCodesShared->removeElement($qrCodesShared)) {
            $qrCodesShared->removeSharedWith($this);
        }

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->password_confirm;
    }

    public function setPasswordConfirm(?string $password_confirm): self
    {
        $this->password_confirm = $password_confirm;

        return $this;
    }
}
