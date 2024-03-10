# OBSHEET 04
MODEL dan ELOQUENT ORM
> Nama : Syahrul Bhudi Ferdiansyah <br>
> NIM  : 2241720167 <br>
> Kelas : TI-2F

### Praktikum 1 - $fillable:
1. Buka file model dengan nama UserModel.php dan tambahkan $fillable seperti gambar di bawah ini
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password'];
}
```
2. Buka file controller dengan nama UserController.php dan ubah script untuk
menambahkan data baru seperti gambar di bawah ini
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index() {
        $data = [
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];
        User::create($data);

        $user = User::all();
        return view('user', ['data' => $user]);
    }
}
```
3. Simpan kode program Langkah 1 dan 2, dan jalankan perintah web server. Kemudian jalankan link localhostPWL_POS/public/user pada browser dan amati apa yang terjadi<br>
![alt text](/public/ss/us.png)<br>
4. Ubah file model UserModel.php seperti pada gambar di bawah ini pada bagian
$fillable
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama'];
}
```

5. Ubah kembali file controller UserController.php seperti pada gambar di bawah hanya bagian array pada $data
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index() {
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        User::create($data);

        $user = User::all();
        return view('user', ['data' => $user]);
    }
}

```
6. Simpan kode program Langkah 4 dan 5. Kemudian jalankan pada browser dan amati apa yang terjadi <br>
![alt text](/public/ss/er.png)<br>
> Setelah dilakukan modifikasi di UserController.php akan membuat error seperti diatas, karena $fillable ‘password’ dihilangkan dan kita melakukan insert data yang memiliki ‘password’ sehingga terjadi error. Perlu ditambahkan $fillable ‘password’ lagi agar bisa menambahkan data. Berikut adalah hasil akhirnya: <br>
![alt text](/public/ss/d.png)<br>
