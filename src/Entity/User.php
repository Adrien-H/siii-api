<?php

namespace App\Entity\User;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="search_idx", columns={"email"})
 *     }
 * )
 *
 * @package App\Entity\User
 */
class User implements UserInterface
{
    /**
     * @Serializer\Groups({"default"})
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $id;

    /**
     * @Serializer\Groups({"default"})
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @ORM\Column(type="string", length=63, nullable=false, unique=true)
     *
     * @var string|null
     */
    private $email;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=511, nullable=false)
     *
     * @var string|null
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=4096)
     *
     * @var string|null
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     *
     * @var string|null
     */
    private $salt;

    /**
     * @var string[]
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     *
     * @param string|null $email
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return self
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string|null $salt
     * @return self
     */
    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return self
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if ($this->email !== $user->getUsername()) {
            return false;
        }
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        return true;
    }

    /**
     * Generates unique API key from User instance.
     *
     * @return string
     *
     * @throws  \UnexpectedValueException  If username is not set yet.
     * @throws  \Exception
     */
    public function generateApiToken(): string
    {
        $username = $this->getUsername();
        if (!$username) {
            throw new \UnexpectedValueException("We need a username to generate API key.");
        }

        return base64_encode(
            time() . bin2hex(random_bytes(64))
        );
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    static public function generateSalt(): string
    {
        return substr(base64_encode(random_bytes(64)), 8, 72);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }
}