<?php

namespace ThatsUs;

use Illuminate\Support\Facades\App;
use TestCase;

class ProtectClassesTest extends TestCase
{
    use ProtectClasses;

    protected $protected_classes = [
        'SomeClass',
    ];

    public function testUnprotected()
    {
        try {
            App::make('SomeClass');
        } catch (\Exception $e) {
        }

        $this->assertNotNull($e);
        $this->assertRegexp('/SomeClass/', $e->getMessage());
    }

    public function testProtected()
    {
        $this->protectClasses();

        $fake = App::make('SomeClass');

        $this->assertInstanceOf(FakeProtectedClass::class, $fake);
    }
}
