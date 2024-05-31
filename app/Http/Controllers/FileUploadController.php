<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FileUploadController extends Controller
{
    public function fileUpload(): View
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        /**
         * validation for image
         */
        $request->validate([
            'berkas' => 'required|file|image|max:5000'
        ]);
        $file = $request->file('berkas');
        $namaFile = 'web-' . time() . '.' . $file->getClientOriginalName();
        $path = $file->move('image', $namaFile);
        $path = str_replace("\\", "//", $path);
        echo "Variabel path berisi: $path <br>";

        $pathBaru = asset('image/' . $namaFile);

        echo "proses upload berhasil, data disimpan pada: $path";
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";
    }
}
