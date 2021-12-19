<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Astronaut;
use App\Exception\AstronautNotFoundException;
use App\Exception\GenerateAvatarPathException;
use App\Exception\ViolationException;
use App\Repository\AstronautRepository;
use App\Validator\AstronautValidator;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;

final class AstronautHandler
{
    public function __construct(
        private AstronautValidator $astronautValidator,
        private AstronautRepository $astronautRepository,
        private EntityManagerInterface $entityManager,
        private AstronautAvatarHandler $astronautAvatarHandler,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws ViolationException
     * @throws \Throwable
     */
    public function create(array $data): Astronaut
    {
        $this->astronautValidator->validate($data, false);

        $astronaut = new Astronaut($data);
        $this->astronautAvatarHandler->update($astronaut);

        try {
            $this->entityManager->persist($astronaut);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
            $this->astronautAvatarHandler->delete($astronaut);

            throw $exception;
        }

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
     * @throws AstronautNotFoundException
     * @throws GenerateAvatarPathException
     * @throws FilesystemException
     * @throws ViolationException
     */
    public function update(int $id, array $data, string $method = 'PATCH'): Astronaut
    {
        $this->astronautValidator->validate($data, $method === 'PATCH');

        /** @var Astronaut $astronaut */
        $astronaut = $this->read($id);
        $lastAvatar = $astronaut->avatar;
        $astronaut->updateFromArray($data);

        if (array_key_exists('avatar', $data) && $data['avatar'] !== $lastAvatar) {
            $this->astronautAvatarHandler->update($astronaut);
            $this->astronautAvatarHandler->delete(new Astronaut(['avatar' => $lastAvatar]));
        }

        $this->entityManager->flush();

        return $astronaut;
    }

    /**
     * @throws AstronautNotFoundException
     * @throws FilesystemException
     */
    // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
    public function delete(int $id): Astronaut
    {
        /** @var Astronaut $astronaut */
        $astronaut = $this->read($id);
        $this->entityManager->remove($astronaut);
        $this->entityManager->flush();
        $this->astronautAvatarHandler->delete($astronaut);

        return $astronaut;
    }
}
