<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_complete_registration_flow()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register.create'))
                    ->assertSee('Persetujuan Menjadi Responden')
                    ->type('name', 'Test User')
                    ->type('email', 'test@example.com')
                    ->check('persetujuan')
                    ->press('Hantar Persetujuan')
                    ->assertPathIs('/demography')
                    ->assertSee('BAHAGIAN A: Latarbelakang Demografi Responden')
                    ->type('phone_number', '0123456789')
                    ->type('age', '50')
                    ->type('place_of_birth', 'Kuala Lumpur')
                    ->select('gender', 'Lelaki')
                    ->select('ethnicity', 'Melayu')
                    ->select('marital_status', 'Berhijrah')
                    ->select('education_level', 'Ijazah Sarjana Muda')
                    ->type('monthly_income_self', '5000')
                    ->type('current_position', 'Pegawai Bomba')
                    ->type('years_of_service', '20')
                    ->select('service_status', 'Pegawai Sepenuh Masa')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->press('Hantar Pendaftaran')
                    ->assertPathIs('/login')
                    ->assertSee('Pendaftaran berjaya! Sila log masuk.');
        });
    }

    /** @test */
    public function it_shows_validation_errors_for_invalid_consent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register.create'))
                    ->press('Hantar Persetujuan')
                    ->assertSee('The name field is required.')
                    ->assertSee('The email field is required.')
                    ->assertSee('The persetujuan field is required.');
        });
    }

    /** @test */
    public function it_shows_validation_errors_for_age_below_45()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register.create'))
                    ->type('name', 'Test User')
                    ->type('email', 'test@example.com')
                    ->check('persetujuan')
                    ->press('Hantar Persetujuan')
                    ->type('age', '40')
                    ->press('Hantar Pendaftaran')
                    ->assertSee('Umur harus sekurang-kurangnya 45 tahun');
        });
    }

    /** @test */
    public function it_shows_validation_errors_for_password_mismatch()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register.create'))
                    ->type('name', 'Test User')
                    ->type('email', 'test@example.com')
                    ->check('persetujuan')
                    ->press('Hantar Persetujuan')
                    ->type('age', '50')
                    ->select('gender', 'Lelaki')
                    ->select('ethnicity', 'Melayu')
                    ->select('marital_status', 'Berhijrah')
                    ->select('education_level', 'Ijazah Sarjana Muda')
                    ->type('monthly_income_self', '5000')
                    ->type('current_position', 'Pegawai Bomba')
                    ->type('years_of_service', '20')
                    ->select('service_status', 'Pegawai Sepenuh Masa')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'differentpassword')
                    ->press('Hantar Pendaftaran')
                    ->assertSee('Pengulangan kata laluan tidak sama');
        });
    }

    /** @test */
    public function it_prevents_access_to_demography_without_consent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register.demography'))
                    ->assertPathIs('/register');
        });
    }
}
