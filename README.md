# HyperPlug

A PHP library for plugging into HTTP sockets.

[![travis-ci.com](https://travis-ci.com/modethirteen/HyperPlug.svg?branch=main)](https://travis-ci.com/modethirteen/HyperPlug)
[![codecov.io](https://codecov.io/github/modethirteen/HyperPlug/coverage.svg?branch=main)](https://codecov.io/github/modethirteen/HyperPlug?branch=main)
[![Latest Stable Version](https://poser.pugx.org/modethirteen/hyperplug/version.svg)](https://packagist.org/packages/modethirteen/hyperplug)
[![Latest Unstable Version](https://poser.pugx.org/modethirteen/hyperplug/v/unstable)](https://packagist.org/packages/modethirteen/hyperplug)

* PHP 7.2, 7.3 (php72, 1.x)
* PHP 7.4+ (main)

## Installation

Use [Composer](https://getcomposer.org/). There are two ways to add this library to your project.

From the composer CLI:

```sh
./composer.phar require modethirteen/hyperplug
```

Or add modethirteen/hyperplug to your project's composer.json:

```json
{
    "require": {
        "modethirteen/hyperplug": "dev-main"
    }
}
```

`dev-main` is the main development branch. If you are using this library in a production environment, it is advised that you use a stable release.

Assuming you have setup Composer's autoloader, the library can be found in the `modethirteen\Http\` namespace.

## Getting Started

A quick example:

```php
$plug = new Plug(XUri::newFromString('https://api.example.com/v2'))
    ->withResultParser(new JsonParser());
$result = $plug->at('users', 'bob')
    ->get();
if($result->isSuccess()) {

    // great job!
    echo $result->getVal('body/name');
}
```

## Usage

```php
// the library allows for programmatic URL construction and parsing
$uri = XUri::newFromString('http://api.example.com/v3')

    // every step in a URL builder returns an immutable XUri object
    ->withScheme('https')
    ->at('widgets')
    ->withQueryParam('xyzzy', 'plugh')
    ->withQueryParams(QueryParams::newFromArray([
        'bar' => 'qux',
        'baz' => 'fred'
    ]))
    ->withoutQueryParam('bar');

// QueryParams objects are normally immutable
$params = $uri->getQueryParams();

// we can change the data structure of a QueryParams object if we must
$params = $params->toMutableQueryParams();
$params->set('baz', 'abc');

// QueryParams are also iterable
foreach($params as $param => $value) {
    $uri = $uri->withReplacedQueryParam($param, $value);
}

// what does our URL look like now?
$result = $uri->toString(); // https://api.example.com/v3/widgets?xyzzy=plugh&baz=abc

// we can give our XUri object to a Plug to create a client
$plug = new Plug($uri);

// like every object in this library, attaching new values or behaviors to plugs is by default immutable
// ...and returns a new object reference

// add credentials for authorization
$plug->withCredentials('franz', 'beckenbauer');

// or a bearer token
$plug->withHeader('Authorization', 'Bearer 12345');

// we can add some additional URL path segments and query parameters that weren't part of the constructing URL
$plug = $plug->at('another', 'additional', 'endpoint', 'segment')->with('more', 'params');

// how many redirects will we follow?
$plug = $plug->withAutoRedirects(2);

// HTTP requests often need HTTP headers
$plug = $plug->withHeader('X-FcStPauli', 'hells')
    ->withAddedHeader('X-FcStPauli', 'bells')
    ->withHeader('X-HSV', 'you\'ll never walk again');

// ...or not
$plug = $plug->withoutHeader('X-HSV');

// the Headers object, like XUri and QueryParams, is normally immutable
$headers = $plug->getHeaders();
$result = $headers->getHeader('X-FcStPauli'); // ['hells', 'bells']
$result = $headers->getHeaderLine('X-FcStPauli'); // X-HSV: hells, bells

// but if you really want to...
$mutableHeaders = $headers->toMutableHeaders();
$mutableHeaders->set('X-HSV', 'keiner mag den hsv');

// a Headers object is iterable
foreach($mutableHeaders as $header => $values) {
    foreach($values as $value) {

        // HTTP headers can have multiple stored values
        // ...though normally sent via an HTTP client as comma separated on a single HTTP header line
        echo "{$header}: {$value}";
    }
}

// also we can merge the two sets of Headers (the original and the mutated one)
// ...to create a brand new object containing the values of both
$mergedHeaders = $headers->toMergedHeaders($mutableHeaders);

// we've built out a pretty complex HTTP client now
// ...but what if we want a client with a different URL but everything else the same?
$alternateApiPlug = $plug->withUri(XUri::newFromString('https://db.example.com/graph'));

// we are going to invoke an HTTP request
// ...pre and post invocation callbacks can attach special logic and handlers
// ...intended to be executed whenever or wherever this HTTP client is used
// ...maybe there is some logic we want to always perform at the moment the HTTP request is about to be sent?
$plug = $plug->withPreInvokeCallback(function(XUri $uri, IHeaders $headers) {

    // last chance to change the URL or HTTP headers before the request is made
    // ...URL and HTTP headers for the single request invocation can be mutated
    // ...this will not affect the URL or HTTP headers configured in the plug
    $headers->toMutableHeaders()->addHeader('something', 'contextual');
});

// multiple callbacks can be attached (they are executed in the order they are attached)
$plug = $plug->withPreInvokeCallback(function(XUri $uri, IHeaders $headers) {
});

// maybe we want to attach some special handlin that always executes when we receive an HTTP response?
$plug = $plug->withPostInvokeCallback(function(Result $result) {

    // perhaps there is special behavior to always trigger based on the HTTP response status code?
    if($result->is(403)) {
    }
});

// HTTP responses can be parsed from text into traversable data structures by attaching one or more ResultParser objects
// ...parsing can be possibly memory intensive, so limits can be put on the allowed size of a response to parse
$plug = $plug->withResultParser((new JsonParser())->withMaxContentLength(640000));

// fetching resources is handled via HTTP GET
$result = $plug->get();

// deleting resources is handled via HTTP
$result = $plug->delete();

// POST or PUT can optionally send data, in a several different content types as needed
$result = $plug->post(
    (new MultiPartFormDataContent([
        'a' => 'b',
        'c' => 'd'
    ]))
    ->withFileContent(new FileContent('/path/to/file'))
);
$result = $plug->put(new FileContent('/path/to/file'));
$result = $plug->post(new UrlEncodedFormDataContent([
    'e' => 'f',
    'g' => 'h'
]));
$result = $plug->post(JsonContent::newFromArray([
    'a' => [
        'multi-dimensional' => [
            'data',
            'structure'
        ]
    ]
]));
$result = $plug->post(XmlContent::newFromArray([
    'another' => [
        'multi-dimensional' => [
            'data',
            'structure'
        ],
        'formatted' => 'as xml'
    ]
]));
$result = $plug->put(new TextContent('good old text!'));
```

You are encouraged to explore the library [classes](src) and [tests](tests) to learn more about the capabilities not listed here.

## Development and Testing

Contributions are always welcome from the community ([there are defects and enhancements to address](https://github.com/modethirteen/HyperPlug/issues)).

The library is tested through a combination of [PHPUnit](https://github.com/sebastianbergmann/phpunit), [`MockPlug`](src/Mock) (an interceptor that matches `HyperPlug` invocations and returns mocked responses), and actual [cURL](https://www.php.net/manual/en/book.curl.php)-driven HTTP requests to a locally hosted [httpbin](https://httpbin.org) server. Further code quality is checked using [PHPStan](https://github.com/phpstan/phpstan) (PHP Static Analysis Tool).

```sh
# fork and clone the HyperPlug repository
git clone git@github.com:{username}/HyperPlug.git

# install dependencies
composer install

# start the httpbin container
docker-compose up -d

# run static analysis checks
vendor/bin/phpstan analyse

# run tests
vendor/bin/phpunit --configuration phpunit.xml.dist
```
