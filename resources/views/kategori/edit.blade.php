@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

@section('content')
    @error('message')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="container">
        <div class="card">
            <div class="card-header">Edit Kategori</div>
            <div class="card-body">
                <a class="btn btn-secondary" href="{{ url('/kategori') }}">Kembali</a>
                <form method="post" action="{{ route('kategori.update', $data->kategori_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="kategori_kode">Kategori Kode</label>
                        <input type="text" class="form-control" id="kategori_kode" name="kategori_kode"
                            value="{{ $data->kategori_kode }}">
                        @error('kategori_kode')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kategori_nama">Kategori Nama</label>
                        <input type="text" class="form-control" id="kategori_nama" name="kategori_nama"
                            value="{{ $data->kategori_nama }}">
                        @error('kategori_nama')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
