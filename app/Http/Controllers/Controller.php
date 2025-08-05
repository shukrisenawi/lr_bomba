<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $scoreLabels, $sections, $partNoScore;

    public function __construct()
    {
        $this->scoreLabels = ['B' => 'JUMLAH SKOR WAI', 'C' => 'JUMLAH SKOR', 'C_subsection_1' => 'JUMLAH SKOR', 'D' => 'JUMLAH SKOR TIAW', 'E_subsection_1' => 'JUMLAH SKOR PRESTASI TUGAS', 'E_subsection_2' => 'JUMLAH SKOR PRESTASI KONTEKSUAL', 'E_subsection_3' => 'JUMLAH SKOR PERILAKU KERJA TIDAK PRODUKTIF', 'E_subsection_4' => 'JUMLAH SKOR KESELURUHAN', 'F' => 'JUMLAH SKOR K6+', 'G' => 'JUMLAH SKOR CES-D', 'H_subsection_1' => 'JUMLAH SKOR KELETIHAN', 'H_subsection_2' => 'JUMLAH SKOR JARAK MENTAL', 'H_subsection_3' => 'JUMLAH SKOR KEMEROSOTAN KOGNITIF', 'H_subsection_4' => 'JUMLAH SKOR KEMEROSOTAN EMOSI', 'H_subsection_5' => 'JUMLAH SKOR KESELURUHAN BAT12', 'I' => 'JUMLAH SKOR REBA', 'L' => 'JUMLAH SKOR IPPT'];

        $this->sections = ['B' => 'Bahagian B: Indek Kebolehan Bekerja ', 'C' => 'Bahagian C: Soal-selidik Kandungan Kerja', 'D' => 'Bahagian D: Impak Latihan Di Tempat Kerja', 'E' => 'Bahagian E: Soal-selidik Prestasi Keja Individu', 'F' => 'Bahagian F: Skala Kemurungan Psikologikal Kessler 6 ', 'G' => 'Bahagian G: Skala Kemurungan CES-D', 'H' => 'Bahagian H: Instrumen Penilaian Kepenatan', 'I' => 'Bahagian I: Penilaian Anggota Keseluruhan Tubuh (REBA)', 'J' => 'Bahagian J: Soal-selidik Muskuloskeletel Nordic (NMQ)', 'K' => 'Bahagian K: Soal-selidik Analisis Kerja (JAQ)', 'L' => 'Bahagian L: Ujian Kecekapan Fizikal Individu (IPPT)'];

        $this->partNoScore = ['J', 'K', 'L'];
    }
}
