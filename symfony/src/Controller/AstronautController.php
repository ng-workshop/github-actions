<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AstronautNotFoundException;
use App\Exception\ViolationException;
use App\Handler\AstronautHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/astronauts', name: 'astronauts_')]
final class AstronautController
{
    public function __construct(private AstronautHandler $astronautHandler)
    {
    }

    #[Route(path: '/{id}', name: 'get', requirements: ['id' => '\d+'], methods: 'GET')]
    public function get(?int $id = null): JsonResponse
    {
        try {
            return new JsonResponse($this->astronautHandler->read($id), Response::HTTP_OK);
        } catch (AstronautNotFoundException $astronautNotFoundException) {
            return new JsonResponse(['error' => $astronautNotFoundException->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(path: '/', name: 'post', methods: ['POST'])]
    public function post(Request $request): JsonResponse
    {
        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $astronaut = $this->astronautHandler->create($data);

            return new JsonResponse($astronaut, Response::HTTP_CREATED);
        } catch (ViolationException $violationException) {
            return new JsonResponse(['error' => $violationException->getViolations()], Response::HTTP_BAD_REQUEST);
        } catch (\JsonException $jsonException) {
            return new JsonResponse(['error' => $jsonException->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(path: '/{id}', name: 'patch', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function patch(int $id, Request $request): JsonResponse
    {
        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $astronaut = $this->astronautHandler->update($id, $data);

            return new JsonResponse($astronaut, Response::HTTP_OK);
        } catch (AstronautNotFoundException $astronautNotFoundException) {
            return new JsonResponse(['error' => $astronautNotFoundException->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (ViolationException $violationException) {
            return new JsonResponse(['error' => $violationException->getViolations()], Response::HTTP_BAD_REQUEST);
        } catch (\JsonException $jsonException) {
            return new JsonResponse(['error' => $jsonException->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(path: '/{id}', name: 'put', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function put(int $id, Request $request): JsonResponse
    {
        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $astronaut = $this->astronautHandler->update($id, $data, 'PUT');

            return new JsonResponse($astronaut, Response::HTTP_OK);
        } catch (AstronautNotFoundException $astronautNotFoundException) {
            return new JsonResponse(['error' => $astronautNotFoundException->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (ViolationException $violationException) {
            return new JsonResponse(['error' => $violationException->getViolations()], Response::HTTP_BAD_REQUEST);
        } catch (\JsonException $jsonException) {
            return new JsonResponse(['error' => $jsonException->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
    #[Route(path: '/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->astronautHandler->delete($id);

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (AstronautNotFoundException $astronautNotFoundException) {
            return new JsonResponse(['error' => $astronautNotFoundException->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
