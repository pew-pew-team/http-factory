<?php

declare(strict_types=1);

namespace PewPew\HttpFactory\Tests\Unit;

use PewPew\HttpFactory\Tests\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('unit'), Group('pew-pew/http-factory')]
abstract class TestCase extends BaseTestCase {}
