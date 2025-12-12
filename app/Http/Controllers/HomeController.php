<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // HALAMAN UTAMA HALAMAN UTAMA HALAMAN UTAMA HALAMAN UTAMA HALAMAN UTAMA HALAMAN UTAMA HALAMAN UTAMA

    public function halamanlogin()
    {
        return view('webutama/halamanlogin');
    }

    public function registrasi()
    {
        return view('webutama/registrasi');
    }

        public function beranda()
    {
        return view('webutama/utamaberanda');
    }

    public function syarat()
    {
        return view('webutama/utamasyarat');
    }

    public function tentang()
    {
        return view('webutama/utamatentang');
    }
}
