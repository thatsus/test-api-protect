# Test API Protect

Avoid hitting third party API's by forcing their client classes to be mocked in Laravel and Lumen tests.

# Protect any classes in Laravel tests

## Install

```bash
composer require thatsus/test-api-protect
```

## Add to TestCase

* Use the ProtectClasses trait,
* list the $protected_classes, and
* call protectClasses in the setUp.

```php

use ThatsUs\ProtectClasses;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    
    use ProtectClasses;

    protected $protected_classes = [
        \Facebook\Facebook::class,
        \GuzzleHttp\Client::class,
        \App\SomeExpensiveClass::class,
    ];

    public function setUp()
    {
        parent::setUp();

        $this->protectClasses();
    }

    ...
}
```

## Make Mistakes with Confidence

Imagine you forgot that this Innocent class uses \App\SomeExpensiveClass.

```php
class InnocentTest extends TestCase
{

    public function testInnocentMethod()
    {
        $good_guy = new Innocent();
        $this->assertTrue($good_guy->everythingIsFine());
    }
}
```

Now you get this error.

```bash
PHPUnit 5.7.16 by Sebastian Bergmann and contributors.

..E..                                                               5 / 5 (100%)

Time: 152 ms, Memory: 14.00MB

There was 1 error:

1) ThatsUs\InnocentTest::testInnocentMethod
Exception: The App\SomeExpensiveClass instance is protected for tests. Setup a mock object using App::bind('App\SomeExpensiveClass', Closure). Method called: doThing.

./vendor/ThatsUs/FakeProtectedClass.php:21
./src/Innocent.php:10
./tests/InnocentTest.php:15

ERRORS!
Tests: 5, Assertions: 6, Errors: 1.
```

You just saved yourself from doing something dangerous! Pat yourself on the back and go edit that test file.

```php
use Illuminate\Support\Facades\App;
use Mockery;

class InnocentTest extends TestCase
{

    public function testInnocentMethod()
    {
        App::bind(\App\SomeExpensiveClass::class, function () {
            $mock = Mockery::mock(\App\SomeExpensiveClass::class);
            $mock->shouldReceive('doThing')->once();
            return $mock;
        });

        $good_guy = new Innocent();
        $this->assertTrue($good_guy->everythingIsFine());
    }
}
```

# No Trouble

If the code under test only instantiates a class without calling any methods on it, no exception is thrown.

# Contribution

If you find a bug or want to contribute to the code or documentation, you can help by submitting an [issue](https://github.com/thatsus/test-api-protect/issues) or a [pull request](https://github.com/thatsus/test-api-protect/pulls).

# License

[MIT](http://opensource.org/licenses/MIT)
