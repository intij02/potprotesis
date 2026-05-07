<?php

use App\Controllers\Client\Auth;
use CodeIgniter\Test\CIUnitTestCase;

final class ClientRegistrationSecurityTest extends CIUnitTestCase
{
    public function testSanitizeSingleLineStripsTagsAndNormalizesWhitespace(): void
    {
        $controller = new Auth();
        $method = $this->privateMethod($controller, 'sanitizeSingleLine');

        $result = $method->invoke($controller, "  <b>Clinica\n Dental</b>   ");

        $this->assertSame('Clinica Dental', $result);
    }

    public function testLooksLikeSpamRegistrationFlagsUrlLikeNames(): void
    {
        $controller = new Auth();
        $method = $this->privateMethod($controller, 'looksLikeSpamRegistration');

        $result = $method->invoke($controller, [
            'name' => 'www.fake-offer.example',
            'email' => 'dentista@example.com',
        ]);

        $this->assertTrue($result);
    }

    public function testLooksLikeSpamRegistrationAllowsNormalDentalOfficeData(): void
    {
        $controller = new Auth();
        $method = $this->privateMethod($controller, 'looksLikeSpamRegistration');

        $result = $method->invoke($controller, [
            'name' => 'Clinica Dental Romero',
            'email' => 'contacto@clinicromero.mx',
        ]);

        $this->assertFalse($result);
    }

    private function privateMethod(object $object, string $methodName): \ReflectionMethod
    {
        $method = new \ReflectionMethod($object, $methodName);
        $method->setAccessible(true);

        return $method;
    }
}
