<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    protected function afterRefreshingDatabase()
    {
        $this->seed(RolesTableSeeder::class);
    }

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test',
            'surname' => 'Testovich',
            'birthdate' => '1990-05-05',
            'email' => 'test@example.com',
            'phone' => '+38(066)4234565',
            'password' => 'qwerty12345',
            'password_confirmation' => 'qwerty12345',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
