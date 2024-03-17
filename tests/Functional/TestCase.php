<?php

declare(strict_types=1);

namespace PewPew\HttpFactory\Tests\Functional;

use PewPew\HttpFactory\Tests\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('functional'), Group('pew-pew/http-factory')]
abstract class TestCase extends BaseTestCase {}
