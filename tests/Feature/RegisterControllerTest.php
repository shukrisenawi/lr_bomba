<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Respondent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_consent_form()
    {
        $response = $this->get(route('register.create'));

        $response->assertStatus(200);
        $response->assertViewIs('register.index');
        $response->assertSee('Persetujuan Menjadi Responden');
    }

    /** @test */
    public function it_stores_consent_with_valid_data()
    {
        $response = $this->post(route('register.store-consent'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'persetujuan' => '1',
        ]);

        $response->assertRedirect(route('register.demography'));
        $response->assertSessionHas('respondent_data', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]);
    }

    /** @test */
    public function it_requires_name_for_consent()
    {
        $response = $this->post(route('register.store-consent'), [
            'email' => 'john@example.com',
            'persetujuan' => '1',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_requires_valid_email_for_consent()
    {
        $response = $this->post(route('register.store-consent'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'persetujuan' => '1',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_unique_email_for_consent()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('register.store-consent'), [
            'name' => 'John Doe',
            'email' => 'existing@example.com',
            'persetujuan' => '1',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_consent_checkbox()
    {
        $response = $this->post(route('register.store-consent'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('persetujuan');
    }

    /** @test */
    public function it_displays_demography_form_with_session_data()
    {
        $response = $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]])->get(route('register.demography'));

        $response->assertStatus(200);
        $response->assertViewIs('register.create');
        $response->assertSee('BAHAGIAN A: Latarbelakang Demografi Responden');
    }

    /** @test */
    public function it_redirects_to_create_if_no_session_data_for_demography()
    {
        $response = $this->get(route('register.demography'));

        $response->assertRedirect(route('register.create'));
    }

    /** @test */
    public function it_completes_registration_with_valid_data()
    {
        $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]]);

        $response = $this->post(route('register.store-demography'), [
            'phone_number' => '0123456789',
            'age' => 50,
            'place_of_birth' => 'Kuala Lumpur',
            'gender' => 'Lelaki',
            'ethnicity' => 'Melayu',
            'marital_status' => 'Berhijrah',
            'education_level' => 'Ijazah Sarjana Muda',
            'monthly_income_self' => 5000,
            'monthly_income_spouse' => 3000,
            'other_income' => 1000,
            'current_position' => 'Pegawai Bomba',
            'grade' => 'KB 41/KB 9',
            'location' => 'Ibu Pejabat Putrajaya',
            'position' => 'Operasi kebombaan dan penyelamat',
            'state' => 'Selangor',
            'years_of_service' => 20,
            'service_status' => 'Pegawai Sepenuh Masa',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Pendaftaran berjaya! Sila log masuk.');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertDatabaseHas('respondents', [
            'user_id' => $user->id,
            'age' => 50,
            'consent_given' => true,
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function it_requires_minimum_age_45_for_registration()
    {
        $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]]);

        $response = $this->post(route('register.store-demography'), [
            'age' => 40,
            'gender' => 'Lelaki',
            'ethnicity' => 'Melayu',
            'marital_status' => 'Berhijrah',
            'education_level' => 'Ijazah Sarjana Muda',
            'monthly_income_self' => 5000,
            'current_position' => 'Pegawai Bomba',
            'years_of_service' => 20,
            'service_status' => 'Pegawai Sepenuh Masa',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['age' => 'Umur harus sekurang-kurangnya 45 tahun']);
    }

    /** @test */
    public function it_requires_password_confirmation_to_match()
    {
        $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]]);

        $response = $this->post(route('register.store-demography'), [
            'age' => 50,
            'gender' => 'Lelaki',
            'ethnicity' => 'Melayu',
            'marital_status' => 'Berhijrah',
            'education_level' => 'Ijazah Sarjana Muda',
            'monthly_income_self' => 5000,
            'current_position' => 'Pegawai Bomba',
            'years_of_service' => 20,
            'service_status' => 'Pegawai Sepenuh Masa',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors(['password' => 'Pengulangan kata laluan tidak sama']);
    }

    /** @test */
    public function it_requires_all_required_fields_for_demography()
    {
        $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]]);

        $response = $this->post(route('register.store-demography'), []);

        $response->assertSessionHasErrors([
            'age',
            'gender',
            'ethnicity',
            'marital_status',
            'education_level',
            'monthly_income_self',
            'current_position',
            'years_of_service',
            'service_status',
            'password',
        ]);
    }

    /** @test */
    public function it_cleans_session_after_successful_registration()
    {
        $this->withSession(['respondent_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'consent_given' => true,
        ]]);

        $response = $this->post(route('register.store-demography'), [
            'age' => 50,
            'gender' => 'Lelaki',
            'ethnicity' => 'Melayu',
            'marital_status' => 'Berhijrah',
            'education_level' => 'Ijazah Sarjana Muda',
            'monthly_income_self' => 5000,
            'current_position' => 'Pegawai Bomba',
            'years_of_service' => 20,
            'service_status' => 'Pegawai Sepenuh Masa',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionMissing('respondent_data');
    }
}
