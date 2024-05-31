<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--link for css bootstrap--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>File Upload</title>
</head>

<body>
<h2 class="m-lg-4">File Upload</h2>
<hr>

<form class="m-lg-4" action="{{url('/file-upload')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="berkas_name" class="form-label">Nama Gambar</label>
        <input type="text" class="form-control" id="berkas_name" name="nama">
        @error('nama')
        <div class="text-danger">{{$message}}</div>
        @enderror
        <label for="berkas" class="form-label">Gambar Profile</label>
        <input type="file" class="form-control" id="berkas" name="berkas">
        @error('berkas')
        <div class="text-danger">{{$message}}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary my-2">Upload</button>
</form>
</body>
</html>
