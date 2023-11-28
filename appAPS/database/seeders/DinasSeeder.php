<?php

namespace Database\Seeders;

use App\Models\Dinas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dinasData = [
            [
                "nama_dinas"=> "Bagian Tata Usaha",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Protokol dan Komunikasi Publik",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Pengelolaan Data dan Dokumentasi",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Perencanaan dan Evaluas",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Hukum",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Keamanan dan Ketertiban",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Bagian Administrasi Umum",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "sekda",
            ],
            [
                "nama_dinas"=> "Dinas Komunikasi dan Informatika",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "opd",
            ],
            [
                "nama_dinas"=> "Dinas Sosial",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "opd",
            ],
            [
                "nama_dinas"=> "Dinas Kesehatan",
                "alamat"=> "Jalan Kartini No.44, Kauman, Jepara, Panggang III, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417",
                "role"=> "opd",
            ],
            [
                "nama_dinas"=> "DPMPTSP",
                "alamat"=> "Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah",
                "role"=> "opd",
            ],
        ];

        // Loop through the data and insert into the dinas table
        foreach ($dinasData as $data) {
            Dinas::create($data);
        }
    }
}
