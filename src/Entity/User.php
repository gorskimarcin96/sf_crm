<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\ApiPlatform\DTO\User\Input;
use App\ApiPlatform\Provider\User\Me;
use App\Controller\Api\User\RegisterController;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user/me',
            openapiContext: [
                'summary' => 'User resource me',
                'description' => 'User resource me',
                'responses' => [
                    Response::HTTP_OK => [
                        'description' => 'User resource me',
                        'content' => [
                            'application/json' => ['schema' => ['$ref' => '#/components/schemas/User-default']],
                        ],
                    ],
                    Response::HTTP_UNAUTHORIZED => ['description' => 'Unauthorized'],
                ],
            ],
            provider: Me::class,
        ),
        new Post(
            uriTemplate: '/user/register',
            controller: RegisterController::class,
            openapiContext: [
                'summary' => 'User registration',
                'description' => 'User registration',
                'responses' => [
                    Response::HTTP_CREATED => [
                        'description' => 'User resource created',
                        'content' => [
                            'application/json' => ['schema' => ['$ref' => '#/components/schemas/User-default']],
                        ],
                    ],
                    Response::HTTP_BAD_REQUEST => ['description' => 'Bad request'],
                    Response::HTTP_UNPROCESSABLE_ENTITY => ['description' => 'Unprocessable entity'],
                ],
            ],
            input: Input::class,
        ),
    ],
    normalizationContext: ['groups' => ['default']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['default'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['default'])]
    private string $email;

    /**
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
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
     * @see UserInterface
     *
     * @return string[]
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
