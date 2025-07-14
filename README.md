<p align="center">
  <a href="" rel="noopener">
 <img src="https://i.pinimg.com/736x/3a/5b/97/3a5b97610d1406b26164d3566cf9d39f.jpg" alt="Project logo"></a>
</p>

<h3 align="center">Sistem Pemesanan Rental Kendaraan PT. Cantigi International Tours</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/kylelobo/The-Documentation-Compendium.svg)](https://github.com/rmaisshadiq/fabulous-five/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/kylelobo/The-Documentation-Compendium.svg)](https://github.com/rmaisshadiq/fabulous-five/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> Dikembangkan oleh Kelompok 5 Project Based Learning <b>[FABULOUS FIVE]</b>, TRPL 2D 2025
    <br> 
</p>

## 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Deployment](#deployment)
- [Usage](#usage)
- [Built Using](#built_using)
- [TODO](../TODO.md)
- [Contributing](../CONTRIBUTING.md)
- [Authors](#authors)
- [Acknowledgments](#acknowledgement)

## 🧐 About <a name = "about"></a>

Proyek ini berfokus pada kebutuhan bisnis rental mobil untuk beradaptasi dengan perkembangan teknologi, meningkatkan efisiensi operasional, mengurangi kesalahan, serta memberikan layanan yang lebih baik bagi pelanggan. Tanpa inovasi ini, bisnis rental mobil berisiko tertinggal dalam persaingan dan mengalami kesulitan dalam mengelola operasional secara optimal.

## 🏁 Getting Started <a name = "getting_started"></a>

Petunjuk ini akan membuat Anda mendapatkan salinan proyek dan menjalankannya di mesin lokal Anda untuk tujuan pengembangan dan pengujian.

### Installing

Buka directory cantigi-project

```
cd cantigi-project
```

Install Composer

```
composer install
```

Install npm module

```
npm install
```

Copy env

```
copy .env-example .env
```

Ganti APP_URL pada .env

```
APP_URL=http://127.0.0.1:8000
```

Migrate database

```
php artisan migrate
```

Link storage

```
php artisan storage:link
```

Generate policy untuk Role

```
php artisan shield:generate --all
```

Jalankan server backend

```
npm run dev
```

Jalankan laravel

```
php artisan serve
```


## 🎈 Usage <a name="usage"></a>

Buat akun

```
php artisan make:filament-user
```

Menjadikan akun tersebut sebagai SUPER_ADMIN

```
php artisan shield:super-admin
```

## ⛏️ Built Using <a name = "built_using"></a>

- [Laravel](https://vuejs.org/) - Web Framework
- [TailwindCSS](https://tailwindcss.com) - UI/UX Component
- [Nodejs](https://nodejs.org/en) - Backend Framework
- [Filamentphp](https://vuejs.org/) - Admin Panel Library
- [Midtrans](https://midtrans.com/en) - Payment Gateway API
- [Filament-Shield](https://midtrans.com/en) - Role Management
- [Filament-ExcelExport](https://filamentphp.com/plugins/pxlrbt-excel) - Excel Export Function
- [Laravel-Breeze](https://github.com/laravel/breeze) - Authentication
- [Dompdf](https://github.com/dompdf/dompdf) - HTML to PDF Converter

## ✍️ Contributors <a name = "authors">Tim Fabulous Five</a>

| No |   Nama Anggota  | NIM | Peran |
| -- | --------------- | --- | ----- |
| 1  | Rafi Maisshadiq | 2311082037 | Project Manager |
| 2  | Muhammad Aldio Yaspindo | 2311081025 | UI/UX Designer |
| 3  | Ahmad Zaky Azda | 2311082003 | Developer |
| 4  | Delonic Ligia | 2311081009 | Technical Writer |

## 🎉 Acknowledgements <a name = "acknowledgement"></a>

- Hat tip to anyone whose code was used
- Inspiration
https://www.traveloka.com
- References
https://filamentphp.com
https://docs.midtrans.com
