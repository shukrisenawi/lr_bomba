<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Respondent;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RespondersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua data responder dengan role 'user' saja
        $responders = User::with([
            'respondent',
            'surveyResponses' => function($query) {
                $query->with(['answers' => function($answerQuery) {
                    $answerQuery->select('id', 'response_id', 'question_id', 'answer', 'value', 'score');
                }]);
            }
        ])->where('role', 'user')->get();

        $data = [];

        foreach ($responders as $user) {
            $respondent = $user->respondent;

            // Data dasar responder - hanya nama, email, dan telefon
            $row = [
                'Nama' => $user->name,
                'Email' => $user->email,
                'No Telefon' => $respondent->phone_number ?? '',
            ];

            // Tambah data demografi dari tabel respondents untuk kolom A1-A24
            $row['A1'] = $user->name; // Nama
            $row['A2'] = $user->email; // E-mel
            $row['A3'] = $respondent->phone_number ?? ''; // No. H/P
            $row['A4'] = $respondent->age ?? ''; // Umur (pada tahun 2025)
            $row['A5'] = $respondent->place_of_birth ?? ''; // Tempat Lahir
            $row['A6'] = $respondent->gender ?? ''; // Jantina
            $row['A7'] = $respondent->ethnicity ?? ''; // Etnik
            $row['A8'] = $respondent->marital_status ?? ''; // Status Perkahwinan
            $row['A9'] = $respondent->education_level ?? ''; // Tahap Pendidikan Tertinggi
            $row['A10'] = $respondent->monthly_income_self ?? ''; // Pendapatan Bulanan (Diri-sendiri)
            $row['A11'] = $respondent->monthly_income_spouse ?? ''; // Pendapatan Bulanan (Pasangan)
            $row['A12'] = $respondent->other_income ?? ''; // Lain-lain Sumber Pendapatan
            $row['A13'] = $respondent->household_income ?? ''; // Pendapatan isi rumah
            $row['A14'] = $respondent->health ?? ''; // Secara umum, saya mengatakan bahawa kesihatan adalah
            $row['A15'] = ''; // Tinggi, Berat, BMI (akan diisi di bawah)
            $row['A16'] = $respondent->blood_type ?? ''; // Kumpulan Darah
            $row['A17'] = ''; // Masalah kesihatan (akan diisi di bawah)
            $row['A18'] = $respondent->current_position ?? ''; // Jawatan Semasa
            $row['A19'] = $respondent->grade ?? ''; // Gred
            $row['A20'] = $respondent->location ?? ''; // Lokasi
            $row['A21'] = $respondent->position ?? ''; // Bahagian
            $row['A22'] = $respondent->state ?? ''; // Negeri
            $row['A23'] = $respondent->years_of_service ?? ''; // Tempoh Perkhidmatan (Tahun)
            $row['A24'] = $respondent->service_status ?? ''; // Status Perkhidmatan

            // Format khusus untuk A15 (Tinggi, Berat, BMI)
            if ($respondent->height && $respondent->weight && $respondent->bmi) {
                $row['A15'] = "Tinggi: {$respondent->height}cm, Berat: {$respondent->weight}kg, BMI: {$respondent->bmi}";
            }

            // Format khusus untuk A17 (Masalah kesihatan - bisa lebih dari satu)
            if ($respondent->health_issue) {
                $healthIssues = [];
                if (is_array($respondent->health_issue)) {
                    $healthIssues = $respondent->health_issue;
                } elseif (is_string($respondent->health_issue)) {
                    $healthIssues = [$respondent->health_issue];
                }

                // Jika ada masalah kesehatan lain, tambahkan
                if ($respondent->other_health_issue) {
                    $healthIssues[] = $respondent->other_health_issue;
                }

                $row['A17'] = implode(', ', array_filter($healthIssues));
            }

            // Tambah jawaban untuk semua soalan dari setiap section (kecuali A yang sudah diisi dari demografi)
            $sections = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

            foreach ($sections as $section) {
                $response = $user->surveyResponses->where('survey_id', $section)->first();

                if ($response) {
                    // Inisialisasi array untuk menyimpan jawaban per question_id
                    $questionAnswers = [];

                    foreach ($response->answers as $answer) {
                        $questionId = $answer->question_id;
                        $answerValue = $answer->answer;

                        // Pastikan question_id valid dan answer tidak kosong
                        if ($questionId !== null && $questionId !== '' && $answerValue !== null) {
                            $questionIdFormatted = $section . $questionId;
                            $questionAnswers[$questionIdFormatted] = $answerValue;
                        }
                    }

                    // Masukkan semua jawaban yang ditemukan ke row
                    foreach ($questionAnswers as $col => $value) {
                        $row[$col] = $value;
                    }

                    // Untuk soalan yang tidak memiliki jawaban, isi dengan kosong
                    for ($i = 1; $i <= 25; $i++) {
                        $questionIdFormatted = $section . $i;
                        if (!isset($row[$questionIdFormatted])) {
                            $row[$questionIdFormatted] = '';
                        }
                    }
                } else {
                    // Jika tidak ada response untuk section ini, isi semua dengan kosong
                    // Untuk section A, hanya sampai A24 (karena A25 tidak ada dalam demografi)
                    $maxQuestions = ($section === 'A') ? 24 : 25;
                    for ($i = 1; $i <= $maxQuestions; $i++) {
                        $questionIdFormatted = $section . $i;
                        $row[$questionIdFormatted] = '';
                    }
                }
            }

            $data[] = $row;
        }

        return collect($data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headers = [
            'Nama',
            'Email',
            'No Telefon',
        ];

        // Tambah header untuk setiap soalan dengan format A1, A2, C1, dll
        // Berdasarkan struktur soalan yang ada dalam sistem
        $questionHeaders = [];

        // Section A - Demografi (sudah diisi dari tabel respondents)
        for ($i = 1; $i <= 24; $i++) {
            $questionHeaders[] = 'A' . $i;
        }

        // Section B sampai L - Survey responses
        for ($section = 'B'; $section <= 'L'; $section++) {
            for ($i = 1; $i <= 25; $i++) {
                $questionHeaders[] = $section . $i;
            }
        }

        return array_merge($headers, $questionHeaders);
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        $widths = [
            'A' => 25, // Nama
            'B' => 30, // Email
            'C' => 15, // No Telefon
        ];

        // Tambah lebar untuk kolom soalan (D sampai dengan kolom yang sangat jauh)
        // Setiap kolom soalan menggunakan lebar 8 untuk menghemat memori
        $questionColumns = [];
        $baseColumns = range('A', 'Z');

        // Untuk kolom D-Z (24 kolom pertama setelah A-C)
        for ($i = 3; $i < 27; $i++) {
            $colIndex = $i % 26;
            $colLetter = $baseColumns[$colIndex];
            if ($i >= 26) {
                $colLetter = 'A' . $colLetter;
            }
            $questionColumns[$colLetter] = 8; // Lebar untuk kolom soalan
        }

        return array_merge($widths, $questionColumns);
    }
}