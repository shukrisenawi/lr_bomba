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
            'surveyResponses.answers'
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

                // Menggunakan query seperti fungsi surveyAnswerReport
                $answers = SurveyAnswer::with('response')
                    ->whereHas('response', function ($query) use ($user, $section) {
                        $query->where('user_id', $user->id)
                            ->where('survey_id', $section);
                    })
                    ->orderBy('question_id', 'asc')
                    ->get();

                if ($answers && $answers->count() > 0) {
                    // Inisialisasi array untuk menyimpan jawaban per question_id
                    $questionAnswers = [];

                    foreach ($answers as $answer) {
                        $questionId = $answer->question_id;
                        $answerValue = $answer->answer;

                        // Pastikan question_id valid dan answer ada
                        if ($questionId !== null && $questionId !== '') {
                            $questionIdFormatted = $questionId; // question_id sudah dalam format C1, C2, dll
                            $questionAnswers[$questionIdFormatted] = $answerValue ?? '';
                        }
                    }

                    // Masukkan semua jawaban yang ditemukan ke row
                    foreach ($questionAnswers as $col => $value) {
                        $row[$col] = $value;
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
        // $headers = [
        //     'Nama',
        //     'Email',
        //     'No Telefon',
        // ];

        // Tambah header untuk setiap soalan dengan format A1, A2, C1, dll
        // Berdasarkan struktur soalan yang ada dalam sistem
        $questionHeaders = [];

        // Section A - Demografi (sudah diisi dari tabel respondents)
        for ($i = 1; $i <= 24; $i++) {
            $questionHeaders[] = 'A' . $i;
        }

        // Section B sampai L - Survey responses
        // Section B hanya memiliki 10 soalan, Section C hanya 21 soalan, Section D hanya 12 soalan, section lainnya 25 soalan
        $sectionLimits = [
            'B' => 10,  // Section B hanya 10 soalan
            'C' => 21,  // Section C hanya 21 soalan (Tuntutan Psikologi + Kawalan Keputusan + Sokongan Sosial)
            'D' => 12,  // Section D hanya 12 soalan
            'E' => 18,
            'F' => 6,
            'G' => 20,
            'H' => 12,
            'I' => 15,
            'J' => 4,
            'K' => 34,
            'L' => 3
        ];

        for ($section = 'B'; $section <= 'L'; $section++) {
            $maxQuestions = $sectionLimits[$section];
            for ($i = 1; $i <= $maxQuestions; $i++) {
                $questionHeaders[] = $section . $i;
            }
        }
        return $questionHeaders;
        // return array_merge($headers, $questionHeaders);
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

        // Tambah lebar untuk kolom soalan A1-A24 dan B1-L25
        // Setiap kolom soalan menggunakan lebar 8 untuk menghemat memori
        $questionColumns = [];

        // Generate column letters untuk semua soalan
        $columns = [];
        for ($i = 1; $i <= 300; $i++) { // Cukup untuk semua kolom
            $col = '';
            $num = $i;
            while ($num > 0) {
                $num--;
                $col = chr(65 + ($num % 26)) . $col;
                $num = intval($num / 26);
            }
            $columns[] = $col;
        }

        // Set lebar untuk semua kolom soalan
        foreach ($columns as $col) {
            $questionColumns[$col] = 8; // Lebar untuk kolom soalan
        }

        return array_merge($widths, $questionColumns);
    }
}
