<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Astronaut;
use App\Exception\GenerateAvatarPathException;
use App\Exception\InvalidBase64EncodedFile;
use App\Exception\NoTemporaryAstronautAvatarFileException;
use App\Exception\ViolationException;
use App\Generator\AvatarPathGenerator;
use App\Specification\IsProtectedAstronautAvatarSpecification;
use App\Specification\IsTemporaryAstronautAvatarSpecification;
use App\Utils\Base64ExtensionGetter;
use App\Validator\AstronautAvatarValidator;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\File;

final class AstronautAvatarHandler
{
    public function __construct(
        private Base64ExtensionGetter $base64ExtensionGetter,
        private AvatarPathGenerator $avatarPathGenerator,
        private FilesystemOperator $tmpStorage,
        private FilesystemOperator $cdnStorage,
        private AstronautAvatarValidator $astronautAvatarValidator,
        private IsProtectedAstronautAvatarSpecification $isProtectedAstronautAvatarSpecification,
        private IsTemporaryAstronautAvatarSpecification $isTemporaryAstronautAvatarSpecification
    ) {
    }

    /**
     * @throws FilesystemException
     * @throws GenerateAvatarPathException
     * @throws InvalidBase64EncodedFile
     * @throws ViolationException
     */
    public function create(string $fileBase64Encoded): string
    {
        $fileName = sprintf(
            '%s.%s',
            uniqid('astronaut_avatar_', true),
            $this->base64ExtensionGetter->getExtension($fileBase64Encoded)
        );

        $this->tmpStorage->write(
            $fileName,
            // phpcs:disable PHPCS_SecurityAudit.BadFunctions.CryptoFunctions.WarnCryptoFunc
            base64_decode(explode('base64,', $fileBase64Encoded)[1])
        );

        try {
            $filePath = $this->avatarPathGenerator->generate(fileName: $fileName);

            $this->astronautAvatarValidator->validate(new File($filePath, true), false);
        } catch (ViolationException | GenerateAvatarPathException $exception) {
            // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
            $this->tmpStorage->delete($fileName);

            throw $exception;
        }

        return $fileName;
    }

    /**
     * @throws GenerateAvatarPathException
     * @throws FilesystemException
     */
    public function update(Astronaut $astronaut): bool
    {
        if (
            false === $this->isTemporaryAstronautAvatarSpecification->isSatisfiedBy($astronaut->avatar) ||
            false  === $this->tmpStorage->fileExists($astronaut->avatar)
        ) {
            throw new NoTemporaryAstronautAvatarFileException($astronaut->avatar);
        }

        $tmpFilePath = $this->avatarPathGenerator->generate(fileName: $astronaut->avatar);
        $avatarPath = $this->avatarPathGenerator->generate(file: new File($tmpFilePath, true), astronaut: $astronaut);

        $this->cdnStorage->writeStream($avatarPath, $this->tmpStorage->readStream($astronaut->avatar));
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->tmpStorage->delete($astronaut->avatar);

        $astronaut->avatar = $avatarPath;

        return true;
    }

    /**
     * @throws FilesystemException
     */
    // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
    public function delete(Astronaut $astronaut): bool
    {
        if (true === $this->isProtectedAstronautAvatarSpecification->isSatisfiedBy($astronaut->avatar)) {
            return false;
        }

        if (false === $this->cdnStorage->fileExists($astronaut->avatar)) {
            return false;
        }

        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->cdnStorage->delete($astronaut->avatar);

        return true;
    }
}
