<?php

namespace Tests\Feature\Feature\Controller;

use App\Helpers\HttpStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    private function getUrl(string $path = null): string
    {
        $url = 'v1:api:auth';
        if ($path) {
            $url .= ':' . $path;
        }

        return route($url);
    }

    /**
     * @test
     */
    public function user_can_sign_in()
    {
        $password = $this->faker->password;
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson($this->getUrl('signin'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function user_cannot_sign_in_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson($this->getUrl('signin'), [
            'email' => $user->email,
            'password' => 'invalid_password',
        ]);
        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The provided credentials are incorrect.',
            ]);
    }

    /**
     * @test
     */
    public function user_can_sign_up()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson($this->getUrl('signup'), $userData);

        $response->assertStatus(HttpStatus::CREATED)
            ->assertJsonStructure(['name', 'email']);
    }

    /**
     * @test
     */
    public function user_cannot_sign_up_with_existing_email()
    {
        $existingUser = User::factory()->create();

        $userData = [
            'name' => $this->faker->name,
            'email' => $existingUser->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson($this->getUrl('signup'), $userData);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * @test
     */
    public function user_cannot_sign_up_with_invalid_password_confirmation()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'invalid_password',
        ];

        $response = $this->postJson($this->getUrl('signup'), $userData);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }
}
