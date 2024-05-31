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
            'nama' => 'required|string|min:3',
            'berkas' => 'required|file|image|max:5000'
        ]);
        $file = $request->file('berkas');
        $namaFile = $request->input('nama') . '.' . $file->getClientOriginalExtension();;

        $path = $file->move('image', $namaFile);
        $path = str_replace("\\", "//", $path);

        $pathBaru = asset('image/' . $namaFile);

        echo "Gambar berhasil diupload ke <a href='$path'>$path</a>";
        echo "<br>";
        echo "<img src='$pathBaru' style='width: 500px; height: 500px; border: 2px solid black;margin-top: 10px;' alt='img'>";
    }
}
