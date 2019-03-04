<?php

namespace Tests\Feature\Tenant\Office;

use Tests\TenantTestCase;
use Illuminate\Auth\AuthenticationException;

class OfficeTest extends TenantTestCase
{

    public function testItCanNotAccessOfficeIfUnauthenticated()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $this->setUpAndActivateTenant();

        $this->get('office');
    }
}
