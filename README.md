<div align="center">
    <p>
        <a href="https://github.com/404NotFoundIndonesia/" target="_blank">
            <img src="https://raw.githubusercontent.com/iqbaleff214/tpq-imam-syafii-web/main/public/logo.png" width="200" alt="TPQ Imam Syafi'i Banjarmasin">
        </a>
    </p>

 [![GitHub Stars](https://img.shields.io/github/stars/iqbaleff214/tpq-imam-syafii-web.svg)](https://github.com/iqbaleff214/tpq-imam-syafii-web/stargazers)
 [![GitHub license](https://img.shields.io/github/license/iqbaleff214/tpq-imam-syafii-web)](https://github.com/iqbaleff214/tpq-imam-syafii-web/blob/main/LICENSE)
 
</div>

# TPQ Imam Syafi'i Web

*Lihat versi aplikasi mobile: [github.com/iqbaleff214/tpq-imam-syafii-android](https://github.com/iqbaleff214/tpq-imam-syafii-android).*

Taman Pendidikan Al-Qur’an atau yang biasa disingkat  TPQ atau TPA merupakan lembaga atau kelompok masyarakat  yang menyelenggarakan pendidikan nonformal jenis keagamaan  Islam yang bertujuan untuk memberikan pengajaran membaca Al -Qur’an sejak usia dini, serta memahami dasar-dasar agama Islam  pada anak usia taman kanak-kanak, sekolah dasar dan/atau  madrasah ibtidaiyah atau bahkan yang lebih tinggi. 

TPQ Imam Syafi’I merupakan salah satu TPQ di kota  Banjarmasin yang masih berada dalam satu lingkungan dengan  Masjid Imam Syafi’i Banjarmasin. Kegiatan pembelajaran di TPQ  Imam Syafi’i Banjarmasin dilakukan seperti TPQ/TPA pada  umumnya yaitu dengan mengajarkan membaca dan menulis Al Qur’an, hafalan surah pendek, hadis dan doa serta materi tambahan  lainnya seputar agama Islam sesuai dengan syariat.
 
Proses pembelajaran dan manajemen pada TPQ Imam  Syafi’i Banjarmasin dilakukan secara manual dan tidak  terintegrasi. Misalkan untuk proses pendaftaran calon santri yang  masih menggunakan formulir yang dicetak di atas kertas dan  mengharuskan calon santri dan/atau walinya untuk bolak-balik  mengurus pendaftaran. Begitu pula saat masa pembelajaran  dimulai, data kehadiran serta hasil pembelajaran santri didapatkan  dari pengajar kemudian dikumpulkan oleh pengelola untuk  dilaporkan kepada kepala TPQ. Data-data yang diperoleh disimpan  di buku pencatatan atau dalam bentuk berkas digital berupa  spreadsheet. 

Pelaksanaan pembelajaran di TPQ Imam Syafi’i  Banjarmasin d imasa pandemi dilaksanakan secara daring. Selama 1 pembelajaran daring di TPQ Imam Syafi’i Banjarmasin, proses  transaksi data seperti kehadiran dan hasil pembelajaran santri  dilakukan melalui aplikasi pengiriman pesan seperti WhatsApp  antara pengajar dan pengelola. 

Pelaksanaan kegiatan secara daring menyebabkan banyak  data yang harus dikelola dengan benar. Hal tersebut dapat diatasi  dengan sistem aplikasi yang dirancang khusus untuk mengelola  dan mengorganisir data-data yang dikumpulkan di lingkungan  TPQ Imam Syafi’i Banjarmasin. Akhirnya penulis memutuskan  untuk membuat sistem aplikasi tersebut yang mana akan  dikembangkan untuk berbasis web dan android. 

## Memulai

### Prasyarat

- Anda memerlukan [PHP](https://www.php.net/downloads) untuk menjalankannya, dengan versi yang terinstal minimal **PHP 7.3**. Pastikan Anda juga dapat mengakses PHP melalui command line dengan menambahkannya ke [environment variable path](https://rgrahardi.medium.com/pengaturan-path-php-dan-composer-di-environment-variables-windows-10-e1e22a637618).
- Pastikan [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) juga terinstal dan dapat diakses melalui command line.
- Pastikan Anda juga telah menginstall [MySQL](https://dev.mysql.com/downloads/mysql/).
- Direkomendasikan untuk menginstall [Git](https://git-scm.com/downloads) untuk manajemen kode yang lebih baik.

### Mengunduh _Source Code_
Anda perlu mengunduh atau menggunakan Git untuk mendapatkan _source code_ ini di komputer Anda. Ada dua cara untuk melakukannya, silakan pilih salah satu.

1. **Unduh File Zip Proyek**

    Anda dapat klik [tautan ini](https://github.com/iqbaleff214/tpq-imam-syafii-web/archive/refs/heads/main.zip) untuk mengunduh file zip dari proyek ini.

2. **Git Clone**

    Pastikan Anda telah menginstall git. Buka direktori di terminal tempat Anda ingin menaruh _source code_. Kemudian, jalankan perintah berikut:
    ```shell
    git clone git@github.com:iqbaleff214/tpq-imam-syafii-web.git
    ```

### Instal Dependensi

Pastikan proyek ini sudah terbuka di command line Anda. Untuk memastikan direktori aktif sekarang Anda di terminal, gunakan perintah berikut:
```shell
pwd
```

Untuk menginstall dependensi laravel, gunakan perintah berikut:
```shell
composer setup
```

Perintah di atas cukup dijalankan __satu kali__ saja!

### Cara Menjalankan
Untuk menjalankan server laravel, gunakan perintah berikut:
```shell
php artisan serve
```

Buka http://localhost:8000 di web browser Anda untuk mengakses _TPQ Imam Syafi'i Web_.

## Daftar Pustaka

[Effendi, M. Iqbal dan Nafila Fayruz. 2021. Sistem Informasi dan Manajemen Taman Pendidikan Al-Qur'an Imam Syafi'i Banjarmasin Berbasis Web dan Aplikasi Android. _Tugas Akhir Diploma 3_. Banjarmasin: Politeknik Negeri Banjarmasin.](https://drive.google.com/file/d/1IcnC0AzTEy1HQBOAmqEvJy7vNhtv4uMu/view?usp=sharing)

## License

__TPQ Imam Syafi'i Web__ adalah perangkat lunak _open-source_ yang dilisensikan di bawah lisensi [MIT license](https://github.com/iqbaleff214/tpq-imam-syafii-web?tab=MIT-1-ov-file).
