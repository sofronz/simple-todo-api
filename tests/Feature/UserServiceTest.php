<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Interfaces\UserInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_successfully()
    {
        // Arrange
        $data = [
            'name'     => 'John Test',
            'email'    => 'john@example.com',
            'password' => bcrypt('password'),
        ];

        // Act
        $user = app(UserInterface::class)->createUser($data);

        // Assert
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $this->assertEquals('John Test', $user->name);
    }
}
