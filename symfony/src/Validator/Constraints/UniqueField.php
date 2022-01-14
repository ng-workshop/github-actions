<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Constraint;

final class UniqueField extends Constraint
{
    public string $message = 'The {{ field }} is already used.';

    public function __construct(
        public ObjectRepository $repository,
        $options = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct($options, $groups, $payload);
    }

    public function getDefaultOption(): string
    {
        return 'repository';
    }
}
