<?php

namespace Tests\Feature\Tenant\Office;

use Illuminate\Auth\AuthenticationException;
use Tests\TenantTestCase;

class OfficeTest extends TenantTestCase
{
    public function testItCanNotAccessOfficeIfUnauthenticated()
    {
        $this->createTenant();
        $this->withoutExceptionHandling();

        $this->expectException(AuthenticationException::class);
        $this->get($this->prepareTenantUrl('office'));
    }
}
