<?php

namespace ThatsUs;

/**
 * This class is used by TestCase to block access to classes that
 * have not been mocked.
 */

class FakeProtectedClass
{
    private $replaces;

    public function __construct($replaces)
    {
        $this->replaces = $replaces;
    }

    public function __call($method, $params)
    {
        throw new \Exception("The {$this->replaces} instance is protected for tests. Setup a mock object using App::bind('{$this->replaces}', Closure). Method called: {$method}.");
    }
}
