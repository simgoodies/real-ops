<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AdditionalAssertions;

    protected function setUp(): void
    {
        parent::setUp();
        Collection::macro('assertEquals', function($collection) {
            $this->zip($collection)->eachSpread(function ($a, $b) {
                Assert::assertTrue($a->is($b));
            });
        });
    }
}
