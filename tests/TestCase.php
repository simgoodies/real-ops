<?php

namespace Tests;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AdditionalAssertions;

    protected $tenancy = false;

    protected function setUp(): void
    {
        parent::setUp();

        Collection::macro('assertEquals', function($collection) {
            $this->zip($collection)->eachSpread(function ($a, $b) {
                Assert::assertTrue($a->is($b));
            });
        });

        if ($this->tenancy) {
            $this->initializeTenancy();
        }
    }

    public function initializeTenancy()
    {
        $tenant = Tenant::create([
            'code' => 'tenant'
        ]);
        tenancy()->initialize($tenant);
    }
}
