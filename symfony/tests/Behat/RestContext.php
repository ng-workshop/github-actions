<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RestContext implements Context
{
    private HttpClientInterface $client;
    private ?ResponseInterface $response = null;

    /** @var array<mixed,mixed> */
    private array $data = [];

    public function __construct(string $baseUri = 'http://nginx')
    {
        $this->client = HttpClient::createForBaseUri($baseUri);
    }

    #[When('I send a :method request to :path')]
    public function iSendRequest(string $method, string $path): void
    {
        try {
            $this->response = $this->client->request($method, $path);
        } catch (TransportExceptionInterface $transportException) { // @SuppressWarnings(PHPMD.EmptyCatchBlock)
        }
    }

    #[when('I send a :method to :path with json data')]
    public function iSendRequestWithJsonData(string $method, string $path, PyStringNode $jsonData): void
    {
        try {
            $arrayData = json_decode($jsonData->getRaw(), true, 512, JSON_THROW_ON_ERROR);
            $this->response = $this->client->request(
                $method,
                $path,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $arrayData,
                ],
            );
        } catch (\JsonException $jsonException) {
            throw new \InvalidArgumentException(sprintf('JSON not well formed: %s', $jsonException->getMessage()));
        } catch (TransportExceptionInterface $transportException) { // @SuppressWarnings(PHPMD.EmptyCatchBlock)
        }
    }

    #[Then('The status code is :statusCode')]
    public function testStatusCodeIs(int $statusCode): void
    {
        if (null === $this->response) {
            // phpcs:disable Generic.Files.LineLength.TooLong
            throw new \Exception('The response is not defined. Please verify to call "iSendRequest" or "isSendRequestWithJsonData"');
        }

        if ($statusCode !== $this->response->getStatusCode()) {
            throw new \Exception(
                sprintf(
                    'Http code does not math "%d". Actual is "%d".',
                    $statusCode,
                    $this->response->getStatusCode(),
                ),
            );
        }
    }

    #[Then('The data is json')]
    public function theDataIsJson(): void
    {
        if (null === $this->response) {
            // phpcs:disable Generic.Files.LineLength.TooLong
            throw new \Exception('The response is not defined. Please verify to call "iSendRequest" or "isSendRequestWithJsonData"');
        }

        try {
            $this->data = $this->response->toArray();
        } catch (HttpExceptionInterface | TransportExceptionInterface $e) {
            $this->data = $this->response->toArray(false);
        }
    }

    #[Then('The json data have :key = :value')]
    public function theJsonDataHaveKeyWithValue(mixed $key, mixed $value): void
    {
        if (false === isset($this->data[$key])) {
            throw new \Exception(
                sprintf(
                    'The json data does not contain a "%s" key.',
                    (string) $key,
                ),
            );
        }

        if ((string) $this->data[$key] !== $value) {
            throw new \Exception(
                sprintf(
                    'The json data for the key "%s" does not correspond to "%s".',
                    (string) $key,
                    (string) $value,
                ),
            );
        }
    }

    #[Then('Element :itemIndex of the json data have :key = :value')]
    public function theElementOfJsonDataHaveKeyWithValue(int $itemIndex, mixed $key, mixed $value): void
    {
        if ($itemIndex >= count($this->data)) {
            throw new \Exception(sprintf('The json data does not index "%d".', $itemIndex));
        }

        if (false === isset($this->data[$itemIndex][$key])) {
            throw new \Exception(
                sprintf(
                    'The json data at element "%d" does not contain a "%s" key.',
                    $itemIndex,
                    (string) $key,
                ),
            );
        }

        if ($this->data[$itemIndex][$key] !== $value) {
            throw new \Exception(
                sprintf(
                    'The json data in element "%d" with the key "%s" does not correspond to "%s".',
                    $itemIndex,
                    (string) $key,
                    (string) $value,
                ),
            );
        }
    }

    #[Then('The response is a violation with')]
    public function theResponseIsAViolationWith(PyStringNode $jsonData): void
    {
        try {
            $arrayData = json_decode($jsonData->getRaw(), true, 512, JSON_THROW_ON_ERROR);

            if ($arrayData !== $this->data) {
                print "\033[31mActual : \n\r";
                print_r($this->data);
                print "\n\r";
                print "Expected: \n\r";
                print_r($arrayData);
                print "\n\r";
                print "\033[39m\n\r";
                throw new \Exception('The response to violations does not match the accepted response.');
            }
        } catch (\JsonException $jsonException) {
            throw new \InvalidArgumentException(sprintf('JSON not well formed: %s', $jsonException->getMessage()));
        }
    }

    #[Then('The json data have :numberItems items')]
    public function theJsonDataHaveNumberItems(int $numberItems): void
    {
        if ($numberItems !== count($this->data)) {
            throw new \Exception(
                sprintf(
                    'The number of item in json data not match "%d". Actual is "%d.',
                    $numberItems,
                    count($this->data),
                ),
            );
        }
    }
}
