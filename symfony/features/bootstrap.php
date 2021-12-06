<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

if (!class_exists(Dotenv::class)) {
    // phpcs:disable Generic.Files.LineLength.TooLong
    throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
}

(new Dotenv())->load(__DIR__ . '/../.env.test');
