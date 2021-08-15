<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

class UserHelpers
{
    public static function getAuthImage(): String
    {
        $foto = null;
        $jk = 'L';
        switch (Auth::user()->peran) {
            case 'Kepala':
            case 'Admin':
                $foto = Auth::user()->administrator->foto;
                $jk = Auth::user()->administrator->jenis_kelamin;
                break;
            case 'Pengajar':
                $foto = Auth::user()->pengajar->foto;
                $jk = Auth::user()->pengajar->jenis_kelamin;
                break;
            case 'Santri':
                $foto = Auth::user()->santri->foto;
                $jk = Auth::user()->santri->jenis_kelamin;
                break;
        }
        $foto = $foto ? "storage/$foto" : (($jk == 'L') ? 'images/ikhwan.svg' : 'images/akhwat.svg');
        return asset($foto);
    }

    public static function getUserImage($image, $gender = null)
    {
        $foto = 'images/ikhwan.svg';
        if ($gender == 'P') $foto = 'images/akhwat.svg';
        if ($image) $foto = "storage/$image";
        return asset($foto);
    }

    public static function getSantriImage($image, $gender = null)
    {
        $foto = 'images/ikhwan-santri.svg';
        if ($gender == 'P') $foto = 'images/akhwat-santri.svg';
        if ($image) $foto = "storage/$image";
        return asset($foto);
    }

    public static function getInfoImage($image)
    {
        return asset($image ? "storage/$image" : "images/info.jpg");
    }
}
