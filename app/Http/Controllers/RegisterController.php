<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondentRequest;
use App\Models\Respondent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan halaman persetujuan
    public function create()
    {
        return view('register.index');
    }

    // Simpan persetujuan
    public function storeConsent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'persetujuan' => 'required|accepted',
        ]);

        $request->session()->put('respondent_data', [
            'name' => $request->name,
            'email' => $request->email,
            'consent_given' => true,
        ]);

        return redirect()->route('register.demography');
    }

    // Tampilkan halaman demografi
    public function showDemographyForm(Request $request)
    {
        $respondentData = $request->session()->get('respondent_data');

        if (!$respondentData) {
            return redirect()->route('register.create');
        }

        return view('register.create', ['session' => (object)$respondentData]);
    }

    // Simpan data demografi
    public function storeDemography(Request $request)
    {
        $respondentData = $request->session()->get('respondent_data');

        if (!$respondentData) {
            return redirect()->route('register.create');
        }
        try {
            $validated = $request->validate([
                'phone_number' => 'nullable|string|max:20',
                'age' => 'required|integer|min:45',
                'place_of_birth' => 'nullable|string|max:255',
                'gender' => 'required',
                'ethnicity' => 'required',
                'marital_status' => 'required',
                'education_level' => 'required|string',
                'monthly_income_self' => 'required|numeric',
                'household_income' => 'required|numeric',
                'monthly_income_spouse' => 'nullable|numeric',
                'other_income' => 'nullable|numeric',
                'current_position' => 'required|string|max:255',
                'grade' => 'nullable|string',
                'location' => 'nullable|string',
                'position' => 'nullable|string',
                'state' => 'nullable|string',
                'years_of_service' => 'required|string',
                'service_status' => 'required',
                'height' => 'required|numeric|min:50|max:250',
                'weight' => 'required|numeric|min:20|max:200',
                'bmi' => 'numeric|min:10|max:50',
                'smoking_status' => 'required|in:never,former,current',
                'alcohol_consumption' => 'required|in:none,occasional,regular,frequent',
                'exercise_frequency' => 'required|in:none,rarely,sometimes,regular,often',
                'medical_history' => 'nullable|string',
                'current_medications' => 'nullable|string',
                'family_medical_history' => 'nullable|string',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'age.min' => 'Age must be at least 45 years old.',
                'password.confirmed' => 'Password confirmation does not match',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $respondentData['name'],
            'email' => $respondentData['email'],
            'password' => Hash::make($validated['password']),
        ]);
        if ($user) {
            // Buat data responden
            Respondent::create([
                'user_id' => $user->id,
                'phone_number' => $validated['phone_number'],
                'age' => $validated['age'],
                'place_of_birth' => $validated['place_of_birth'],
                'gender' => $validated['gender'],
                'ethnicity' => $validated['ethnicity'],
                'marital_status' => $validated['marital_status'],
                'education_level' => $validated['education_level'],
                'monthly_income_self' => $validated['monthly_income_self'],
                'household_income' => $validated['household_income'],
                'monthly_income_spouse' => $validated['monthly_income_spouse'] ?? null,
                'other_income' => $validated['other_income'] ?? null,
                'current_position' => $validated['current_position'],
                'grade' => $validated['grade'] ?? null,
                'location' => $validated['location'] ?? null,
                'position' => $validated['position'] ?? null,
                'state' => $validated['state'] ?? null,
                'years_of_service' => $validated['years_of_service'],
                'service_status' => $validated['service_status'],
                'height' => $validated['height'],
                'weight' => $validated['weight'],
                'bmi' => $validated['bmi'],
                'smoking_status' => $validated['smoking_status'],
                'alcohol_consumption' => $validated['alcohol_consumption'],
                'exercise_frequency' => $validated['exercise_frequency'],
                'medical_history' => $validated['medical_history'] ?? null,
                'current_medications' => $validated['current_medications'] ?? null,
                'family_medical_history' => $validated['family_medical_history'] ?? null,
                'consent_given' => true,
            ]);
        }
        $request->session()->forget('respondent_data');

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        Auth::attempt($credentials);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome.');
    }
}
