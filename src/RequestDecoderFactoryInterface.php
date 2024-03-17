<?php

declare(strict_types=1);

namespace PewPew\HttpFactory;

use Symfony\Component\HttpFoundation\Request;

interface RequestDecoderFactoryInterface
{
    public function createDecoder(Request $request): ?RequestDecoderInterface;
}
