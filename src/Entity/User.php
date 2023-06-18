<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\ApiPlatform\DTO\User\Model\Input;
use App\ApiPlatform\DTO\User\Processor;
use App\ApiPlatform\DTO\User\Provider;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/users/me',
            openapiContext: [
                'summary' => 'Retrieves the User me resource.',
                'description' => 'Retrieves the User me resource.',
            ]
        ),
        new Post(
            uriTemplate: '/users/register',
            openapiContext: [
                'summary' => 'User registration',
                'description' => 'User registration',
                'responses' => [
                    Response::HTTP_CREATED => [
                        'description' => 'User resource created.',
                    ],
                    Response::HTTP_BAD_REQUEST => ['description' => 'Bad request.'],
                    Response::HTTP_UNPROCESSABLE_ENTITY => ['description' => 'Unprocessable entity.'],
                ],
            ],
        ),
    ],
    normalizationContext: ['groups' => ['user:read', 'created_at:read', 'updated_at:read']],
    input: Input::class,
    provider: Provider::class,
    processor: Processor::class,
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Stringable
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['user:read'])]
    private Uuid $uuid;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read'])]
    private string $email;

    /**
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    private ?string $plainPassword = null;

    public function __toString(): string
    {
        return $this->email;
    }

    public function __construct()
    {
        $this->uuid = Uuid::v1();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = Uuid::fromString($uuid);

        return $this;
    }

    public function getEmail(): string
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
        return $this->email;
    }

    /**
     * @return string[]
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
