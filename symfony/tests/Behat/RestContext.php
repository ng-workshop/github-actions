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
    private string $cacheFilePath;
    private HttpClientInterface $client;
    private ?ResponseInterface $response = null;

    /** @var array<mixed,mixed> */
    private array $data = [];

    public function __construct(string $baseUri)
    {
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $this->cacheFilePath = \dirname(__DIR__) . '/../var/cache/.behat-cache';
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

    #[When('I send a :method to :path replacing the values in path with the last cached json response')]
    public function iSendRequestReplacingTheValuesInPathWithTheLastCachedJsonResponse(
        string $method,
        string $path
    ): void {
        foreach ($this->getCache() as $key => $value) {
            $path = str_replace(sprintf('{%s}', $key), $value, $path);
        }

        $this->clearCache();

        $this->iSendRequest($method, $path);
    }

    #[when('I send a :method to :path with json data and temporary astronaut avatar')]
    public function iSendRequestWithJsonDataWithTemporaryAvatar(
        string $method,
        string $path,
        PyStringNode $jsonData
    ): void {
        $strings = [];
        $numberOfSubstitutions = 0;

        foreach ($jsonData->getStrings() as $string) {
            if (1 === preg_match('/##TEMPORARY_ASTRONAUT_AVATAR##/', $string)) {
                $string = str_replace('##TEMPORARY_ASTRONAUT_AVATAR##', $this->data['filename'], $string);
                $numberOfSubstitutions++;
            }

            $strings[] = $string;
        }

        if (0 === $numberOfSubstitutions) {
            throw new \Exception('No avatar replacement has been done.');
        }

        $this->iSendRequestWithJsonData($method, $path, new PyStringNode($strings, $jsonData->getLine()));
    }

    #[when('I send a :method to :path with file :filename')]
    public function iSendRequestWithFile(string $method, string $path, string $filename): void
    {
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $filePath = \dirname(__DIR__) . '/Resources/' . $filename;
        $type = pathinfo($filePath, PATHINFO_EXTENSION);
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.FilesystemFunctions.WarnFilesystem
        $data = file_get_contents($filePath);
        // phpcs:disable PHPCS_SecurityAudit.BadFunctions.CryptoFunctions.WarnCryptoFunc
        // @phpstan-ignore-next-line
        $fileBase64Encoded = 'data:image/' . $type . ';base64,' . base64_encode($data);

        try {
            $this->response = $this->client->request(
                $method,
                $path,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => ['file' => $fileBase64Encoded],
                ],
            );
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

    #[Then('The json data have :key')]
    public function theJsonDataHaveKey(mixed $key): void
    {
        if (false === isset($this->data[$key])) {
            throw new \Exception(
                sprintf(
                    'The json data does not contain a "%s" key.',
                    (string) $key,
                ),
            );
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

    #[Then('Cache response')]
    public function saveFilename(): void
    {
        $this->saveCache($this->data);
    }

    /**
     * @param array<mixed, mixed> $data
     */
    private function saveCache(array $data): void
    {
        file_put_contents($this->cacheFilePath, serialize($data));
    }

    /**
     * @return array<mixed, mixed>
     */
    private function getCache(): array
    {
        return unserialize((string) file_get_contents($this->cacheFilePath));
    }

    private function clearCache(): void
    {
        if (file_exists($this->cacheFilePath)) {
            unlink($this->cacheFilePath);
        }
    }
}
