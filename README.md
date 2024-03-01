# JOBSHEET 03 MIGRATION, SEEDER, DB FAÇADE, QUERY BUILDER, dan ELOQUENT ORM
> Nama : Syahrul Bhudi Ferdiansyah <br>
> NIM  : 2241720167 <br>
> Kelas : TI-2F

## Pengaturan Database
-Praktikum 1
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
## Migration
-Praktikum 2.1
- buat file migrasi untuk table m_level dengan perintah<br>
![alt text](./public/screenshot/migra.png)<br>
![alt text](./public/screenshot/migra1.png)<br>
- modifikasi sesuai desain database yang sudah ada
    ```php
    public function up(): void
        {
            Schema::create('m_level', function (Blueprint $table) {
                $table->id("level_id");
                $table->string("level_kode", 10)->unique();
                $table->string("level_nama", 100);
                $table->timestamps();
            });
        }
    ```
- Simpan kode pada tahapan 4 tersebut, kemudian jalankan perintah ini pada terminal VSCode untuk melakukan migrasi<br>
![alt text](./public/screenshot/mi.png)<br>
- Kemudian kita cek di phpMyAdmin apakah table sudah ter-generate atau belum
![alt text](./public/screenshot/ss.png)
- Buat table database dengan migration untuk table m_kategori yang sama-sama tidak memiliki foreign key
    ```php
        public function up(): void
    {
        Schema::create('m_kategori', function (Blueprint $table) {
            $table->id("kategori_id");
            $table->string("kategori_kode", 10)->unique();
            $table->string("kategori_nama", 100);
            $table->timestamps();
        });
    }
    ```
    ![alt text](./public/screenshot/kate.png)<br>
-Praktikum 2.2
- Buat file migrasi untuk table m_user<br>
![alt text](./public/screenshot/tab.png)
- Buka file migrasi untuk table m_user, dan modifikasi seperti berikut<br>
![alt text](./public/screenshot/us.png)<br>
- alankan perintah php artisan migrate. Amati apa yang terjadi pada database.<br>
![alt text](./public/screenshot/migrat.png)
>Hal yang terjadi adalah pada database terbentuk tabel baru yang bernama m_user yang sudah menjalin hubungan dengan m_level
![alt text](./public/screenshot/usr.png)
- Buat table database dengan migration untuk table-tabel yang memiliki foreign key <br>
  - m_barang<br>
  ![alt text](./public/screenshot/br.png)<br>
  - t_penjualan<br>
    ![alt text](./public/screenshot/pn.png)<br>
  - t_stok<br>
  ![alt text](./public/screenshot/st.png)<br>
  - t_penjualan_detail<b>
    ![alt text](./public/screenshot/de.png)<br>
- Bentuk Hubungan<br>
![alt text](./public/screenshot/erd.png)<br>

