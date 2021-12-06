<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Astronaut;
use App\Exception\AstronautNotFoundException;
use App\Exception\ViolationException;
use App\Repository\AstronautRepository;
use App\Validator\AstronautValidator;
use Doctrine\ORM\EntityManagerInterface;

final class AstronautHandler
{
    public function __construct(
        private AstronautValidator $astronautValidator,
        private AstronautRepository $astronautRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws ViolationException
     */
    public function create(array $data): Astronaut
    {
        $violations = $this->astronautValidator->validate($data);

        if (0 !== count($violations)) {
            throw new ViolationException($violations);
        }

        $astronaut = new Astronaut($data);

        $this->entityManager->persist($astronaut);
        $this->entityManager->flush();

        return $astronaut;
    }

    /**
     * @return Astronaut|array<Astronaut>
     *
     * @throws AstronautNotFoundException
     */
    public function read(?int $id = null): Astronaut|array
    {
        if (null === $id) {
            return $this->astronautRepository->findAll();
        }

        $astronaut = $this->astronautRepository->find($id);

        if (null === $astronaut) {
            throw new AstronautNotFoundException($id);
        }

        return $astronaut;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws AstronautNotFoundException|ViolationException
     */
    public function update(int $id, array $data, string $method = 'PATCH'): Astronaut
    {
        /** @var Astronaut $astronaut */
        $astronaut = $this->read($id);
        $violations = $this->astronautValidator->validate($data, $method === 'PATCH');

        if (0 !== count($violations)) {
            throw new ViolationException($violations);
        }

        $astronaut->updateFromArray($data);
        $this->entityManager->flush();

        return $astronaut;
    }

    /**
     * @throws AstronautNotFoundException
     */
    // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
    public function delete(int $id): void
    {
        /** @var Astronaut $astronaut */
        $astronaut = $this->read($id);
        $this->entityManager->remove($astronaut);
        $this->entityManager->flush();
    }
}
