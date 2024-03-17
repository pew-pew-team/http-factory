<p align="center">
    <a href="https://github.com/pew-pew-team"><img src="https://raw.githubusercontent.com/pew-pew-team/.github/master/assets/logo.svg" width="128" height="128" /></a>
</p>

<p align="center">
    <a href="https://packagist.org/packages/pew-pew/http-factory"><img src="https://poser.pugx.org/pew-pew/http-factory/require/php?style=for-the-badge" alt="PHP 8.3+"></a>
    <a href="https://packagist.org/packages/pew-pew/http-factory"><img src="https://poser.pugx.org/pew-pew/http-factory/version?style=for-the-badge" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/pew-pew/http-factory"><img src="https://poser.pugx.org/pew-pew/http-factory/v/unstable?style=for-the-badge" alt="Latest Unstable Version"></a>
    <a href="https://raw.githubusercontent.com/pew-pew-team/http-factory/blob/master/LICENSE"><img src="https://poser.pugx.org/pew-pew/http-factory/license?style=for-the-badge" alt="License MIT"></a>
</p>
<p align="center">
    <a href="https://github.com/pew-pew-team/http-factory/actions"><img src="https://github.com/pew-pew-team/http-factory/workflows/tests/badge.svg"></a>
    <a href="https://github.com/pew-pew-team/http-factory/actions"><img src="https://github.com/pew-pew-team/http-factory/workflows/codestyle/badge.svg"></a>
    <a href="https://github.com/pew-pew-team/http-factory/actions"><img src="https://github.com/pew-pew-team/http-factory/workflows/security/badge.svg"></a>
    <a href="https://github.com/pew-pew-team/http-factory/actions"><img src="https://github.com/pew-pew-team/http-factory/workflows/static-analysis/badge.svg"></a>
</p>

# HTTP Factory

A set of drivers for encoding HTTP responses and decoding HTTP requests.

## Installation

PewPew HTTP Factory is available as Composer repository and can be installed
using the following command in a root of your project:

```bash
$ composer require pew-pew/http-factory
```

More detailed installation [instructions are here](https://getcomposer.org/doc/01-basic-usage.md).

## Usage

### Decoder

```php
// Symfony Request
$request = new \Symfony\Component\HttpFoundation\Request();

// Requests Factory
$requests = new \PewPew\HttpFactory\RequestDecoderFactory([
    new \PewPew\HttpFactory\Driver\JsonDriver(),
]);

$payload = $requests
    ->createDecoder($request) // Detect passed "content-type" header and
                              // create decoder if available.
    ?->decode($request->getContent(true));   // Decode request body.
```

### Encoder

```php
// Symfony Request
$request = new \Symfony\Component\HttpFoundation\Request();

// Responses Factory
$responses = new \PewPew\HttpFactory\ResponseEncoderFactory([
    new \PewPew\HttpFactory\Driver\JsonDriver(),
]);

$response = $responses
    ->createEncoder($request) // Detect passed "accept" header and create
                              // encoder if available.
    ?->encode(['some' => 'any'], 200);  // Encode payload and create response.
```

### Symfony Integration

Add the bundle to your `bundles.php` file:

```php
// bundles.php
return [
    // ...
    PewPew\HttpFactory\HttpFactoryBundle::class => ['all' => true],
];
```

Use `ResponseEncoderFactoryInterface` and `RequestDecoderFactoryInterface` 
in your services:

```php
use PewPew\HttpFactory\ResponseEncoderFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final readonly class ExampleController
{
    public function __construct(
        private ResponseEncoderFactoryInterface $responses,
    ) {}
    
    public function someAction(Request $request): Response 
    {
        $encoder = $this->responses->createEncoder($request);
        
        if ($encoder === null) {
            throw new \Symfony\Component\HttpFoundation\Exception\BadRequestException(
                'Unsupported "accept" request header',
            );
        }
        
        return $encoder->encode([
            'status' => 'ok'
        ], Response::HTTP_OK);
    }
}
```
