<?php

declare(strict_types=1);

namespace PewPew\HttpFactory;

interface RequestDecoderInterface
{
    public function decode(string $payload): object|array;
}
