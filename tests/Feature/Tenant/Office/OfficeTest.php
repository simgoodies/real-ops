<?php

namespace Tests\Feature\Tenant\Office;

use Tests\TenantTestCase;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class OfficeTest extends TenantTestCase
{
    public function testItCanNotAccessOfficeIfUnauthenticated()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $this->setUpAndActivateTenant();

        $this->get('office');
    }
    
    public function testItCannotAccessStaffManagementWithStaffRole()
    {
        $this->expectException(UnauthorizedException::class);
        $this->withoutExceptionHandling();
        
        $this->setUpAndActivateTenant();
        $this->loggedInStaffUser();
        
        $this->get('office/staff-management');
    }
}
