<?php
//https://sharemycode.fr/9fm
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class UserTest extends TestCase
{
    /**
     * @dataProvider getValidationTestCases
     */
    public function testUserValidationPasses($nom, $prenom, $email, $password, $expected): void
    {
        //Arrange
        $user = User::build($nom, $prenom, $email, $password);
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        // Act
        $result = $validator->validate($user);

        // Assert
        $this->assertEquals($expected, count($result) == 0);
    }
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    public function getValidationTestCases()
    {
        return [
            'Succeeds when data is correct' => ['soupra', 'mani', 'soupramani@yahoo.fr', 'abc7Q@az', true],
            'Fails when nom is blank' => ['', 'mani', 'soupramani@yahoo.fr', 'abc7Q@az', false],
            'Fails when prénom is blank' => ['soupra', '', 'soupramani@yahoo.fr', 'abc7Q@az', false],
            'Fails when email is not valid' => ['soupra', 'mani', 'soupramaniyahoo.fr', 'abc7Q@az', false],
            'Fails when password is missing' => ['soupra', 'mani', 'soupramani@yahoo.fr', '', false],
            'Fails when password contains less than 8 character' => ['soupra', 'mani', 'soupramani@yahoo.fr', 'abc7Q@a', false],
            'Fails when password does not contain a special character' => ['soupra', 'mani', 'soupramani@yahoo.fr', 'abc7Qkla', false],
            'Fails when password does not contain a uppercase character' => ['soupra', 'mani', 'soupramani@yahoo.fr', 'abc7q@kla', false],
            'Fails when password does not contain a lowercase character' => ['soupra', 'mani', 'soupramani@yahoo.fr', '1144A@DF', false],
            'Fails when password does not contain a digit' => ['soupra', 'mani', 'soupramani@yahoo.fr', 'abcaQ@az', false],
        ];
    }
}

