# JOBSHEET 03 MIGRATION, SEEDER, DB FAÇADE, QUERY BUILDER, dan ELOQUENT ORM
> Nama : Syahrul Bhudi Ferdiansyah <br>
> NIM  : 2241720167 <br>
> Kelas : TI-2F

## Pengaturan Database
- Buka aplikasi phpMyAdmin, dan buat database baru dengan nama PWL_POS<br>
![alt text](./public/screenshot/db.png)<br>
- Buka file .env, dan pastikan konfigurasi APP_KEY bernilai. Jika belum bernilai silahkan kalian generate menggunakan php artisan.
    ```shell
    APP_KEY=base64:pf+9aFnSDEboKCBeqGLwrtquEsEky8sZEMMbe2xU8Js=
    ```
- Edit file .env dan sesuaikan dengan database yang telah dibuat
    ```shell
    DB_CONNECTION=mysql
    DB_HOST=172.17.0.1
    DB_PORT=3306
    DB_DATABASE=PWL_POS
    DB_USERNAME=root
    DB_PASSWORD=
    ```
-
