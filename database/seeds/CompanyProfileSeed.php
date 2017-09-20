<?php

use Illuminate\Database\Seeder;

class CompanyProfileSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = new \App\CompanyProfile();
        $company->nama_toko = "Toko Pupuk";
        $company->telp = "081223596458";
        $company->alamat = "Jl. Ahmad Yani No. 405 - Garut";
        $company->save();

    }
}
