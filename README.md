# JOBSHEET 07 - LARAVEL STARTER CODE

> Nama : Syahrul Bhudi Ferdiansyah <br>
> NIM : 2241720167 <br>
> Kelas : TI-2F

## A. Layouting AdminLTE
- Hasil akhir template.blade.php<br>
![img.png](public/ss/js7(1).png)<br>
## B. Penerapan Layouting
- Welcome Controller
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
	}
}
```
- Welcome.blade 
```php
@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Halo, apakabar!!!</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            Selamat datang semua, ini adalah halaman utama dari aplikasi ini
        </div>
    </div>
@endsection
```
- Modifikasi breadcrumb blade
```php
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$breadcrumb->title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach($breadcrumb->list as $key => $value)
                        @if($key == count($breadcrumb->list - 1))
                            <li class="breadcrumb-item active">{{$value}}</li>
                        @else
                            <li class="breadcrumb-item">{{$value}}</li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
```
- Hasil <br>
![img.png](public/ss/js7(2).png)<br>

## C. Implementasi jQuery Datatable
- Modifikasi Route
```php
Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});
```
- Modifikasi UserController
```php
function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
```
- Hasil<br>
![img.png](public/ss/js(7).3.1.png)
- Create <br>
![img.png](public/ss/js7.3.2.png)
- Hasil create<br>
![img.png](public/ss/js7.3.3.png)
> Disini saya menambahkan pelanggan12 dengan nama Ahmad Soerjo dan hasilnya sukses tersimpan di database
- Hasil show<br>
![img.png](public/ss/js7.3.4.png)
> Hasilnya sesuai, data user ditampilkan dengan benar
- Hasil edit<br>
![img.png](public/ss/js7.3.6.png)<br>
![img.png](public/ss/js7.3.7.png)<br>
> Disini saya mengganti nama dari pelanggan12 menjadi Ahmad Soerjo Raharjo dan berhasil
- Hasil delete<br>
![img.png](public/ss/js7.3.8.png)<br>
>Disini saya mencoba menghapus manager 56<br>

<br>![img.png](public/ss/js7.3.9.png)<br>
> Hasilnya user manager 56 berhasil di hapus

