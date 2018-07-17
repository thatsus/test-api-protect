<?php

namespace ThatsUs;

use TestCase;

class FakeProtectedClassTest extends TestCase
{

    public function testInstantiate()
    {
        new FakeProtectedClass('some string');
    }

    public function testMagicCall()
    {
        $fake = new FakeProtectedClass('some string');

        try {
            $fake->someMethod();
        } catch (\Exception $e) {
        }

        $this->assertNotNull($e);
        $this->assertRegexp('/some string/', $e->getMessage());
        $this->assertRegexp('/someMethod/', $e->getMessage());
    }
}
