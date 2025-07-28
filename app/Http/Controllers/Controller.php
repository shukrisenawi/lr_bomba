<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $scoreLabels, $sections;

    public function __construct()
    {
        $this->scoreLabels = ['A' => 'JUMLAH SKOR WAI', 'B' => 'JUMLAH SKOR', 'C' => 'JUMLAH SKOR TIAW', 'D_subsection_1' => 'JUMLAH SKOR PRESTASI TUGAS', 'D_subsection_2' => 'JUMLAH SKOR PRESTASI KONTEKSUAL', 'D_subsection_3' => 'JUMLAH SKOR PERILAKU KERJA TIDAK PRODUKTIF', 'D_subsection_4' => 'JUMLAH SKOR KESELURUHAN', 'E' => 'JUMLAH SKOR K6+', 'F' => 'JUMLAH SKOR CES-D', 'G_subsection_1' => 'JUMLAH SKOR KELETIHAN', 'G_subsection_2' => 'JUMLAH SKOR JARAK MENTAL', 'G_subsection_3' => 'JUMLAH SKOR KEMEROSOTAN KOGNITIF', 'G_subsection_4' => 'JUMLAH SKOR KEMEROSOTAN EMOSI', 'G_subsection_5' => 'JUMLAH SKOR KESELURUHAN BAT12', 'H' => 'JUMLAH SKOR REBA'];

        $this->sections = ['A' => 'Indek Kebolehan Bekerja ', 'B' => 'Soal-selidik Kandungan Kerja', 'C' => 'Impak Latihan Di Tempat Kerja', 'D' => 'Soal-selidik Prestasi Keja Individu', 'E' => 'Skala Kemurungan Psikologikal Kessler 6 ', 'F' => 'Skala Kemurungan CES-D', 'G' => 'Instrumen Penilaian Kepenatan', 'H' => 'Penilaian Anggota Keseluruhan Tubuh (REBA)'];
    }
}
