<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NoTemporaryAstronautAvatarFileException;
use App\Exception\ViolationException;
use App\Handler\AstronautAvatarHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/astronauts/avatars', name: 'astronauts_avatars_')]
final class AstronautAvatarController
{
    public function __construct(
        private AstronautAvatarHandler $astronautAvatarHandler,
        private SerializerInterface $serializer
    ) {
    }

    #[Route(path: '', name: 'post', methods: ['POST'])]
    public function post(Request $request): JsonResponse
    {
        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            return new JsonResponse(
                ['filename' => $this->astronautAvatarHandler->create($data['file'])],
                Response::HTTP_CREATED
            );
        } catch (ViolationException $violationException) {
            return new JsonResponse(
                $this->serializer->serialize($violationException, 'json', []),
                Response::HTTP_BAD_REQUEST,
                [],
                true,
            );
        } catch (\JsonException $jsonException) {
            return new JsonResponse(['error' => $jsonException->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
    #[Route(path: '/{filePath}', name: 'delete', requirements: ['id' => '[a-zA-z0-9\.\-_]+'], methods: ['DELETE'])]
    public function delete(string $filePath): JsonResponse
    {
        try {
            $this->astronautAvatarHandler->deleteTemporary($filePath);

            return new JsonResponse();
        } catch (NoTemporaryAstronautAvatarFileException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()]);
        }
    }
}
