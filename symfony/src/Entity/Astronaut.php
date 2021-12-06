<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[
    Entity,
    HasLifecycleCallbacks,
    Index(columns: ["username"], name: "username_astronaut_idx"),
    Index(columns: ["planet"], name: "planet_astronaut_idx"),
    Index(columns: ["email"], name: "email_astronaut_idx"),
    UniqueConstraint(name: "search_astronaut_idx", columns: ["username", "email"]),
]
class Astronaut
{
    #[
        Id,
        Column(name: "id", type: "integer"),
        GeneratedValue(strategy: "AUTO"),
        SequenceGenerator(sequenceName: "astronauts_seq", allocationSize: 1, initialValue: 1),
    ]
    public int $id;

    #[Column(name: "username", length: 50, unique: true, nullable: false)]
    public string $username;

    #[Column(name: "planet", length: 20, nullable: false)]
    public string $planet;

    #[Column(name: "email", length: 100, unique: true, nullable: false)]
    public string $email;

    #[Column(name: "avatar", length: 255, nullable: false)]
    public string $avatar;

    #[Column(name: "created_at", type: "datetime_immutable", nullable: false)]
    public DateTimeImmutable $createdAt;

    #[Column(name: "updated_at", type: "datetime", nullable: false)]
    public DateTime $updatedAt;

    /** @param array<string, string> $data */
    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    #[PrePersist]
    public function setUpdatedAt(): void
    {
        $this->updatedAt->setTimestamp(time());
    }

    /** @param array<string, string> $data */
    public function updateFromArray(array $data): self
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }

        return $this;
    }
}
