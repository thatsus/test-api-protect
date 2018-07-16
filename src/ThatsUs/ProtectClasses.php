<?php

namespace ThatsUs;

use Illuminate\Support\Facades\App;

trait ProtectClasses
{

    /**
     * Mock these classes so that they will
     * not be accidentally used in tests.
     */
    protected function protectClasses()
    {
        if (!isset($this->protected_classes)) {
            throw new \Exception('The $protected_classes array is not defined in the test class.');
        }
        foreach ($this->protected_classes as $instance_name) {
            $this->bindProtectedClass($instance_name);
        }
    }

    protected function bindProtectedClass($instance_name)
    {
        App::bind($instance_name, function () use ($instance_name) {
            return new FakeApiClient($instance_name);
        });
    }

}
