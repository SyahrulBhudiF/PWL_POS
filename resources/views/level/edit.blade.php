@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Level</div>
            <div class="card-body">
                <a class="btn btn-secondary" href="{{ url('/level') }}">Kembali</a>
                <form method="post" action="{{ route('level.update', $data->level_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="level_kode">Level Kode</label>
                        <input type="text" class="form-control" id="level_kode" name="level_kode"
                            value="{{ $data->level_kode }}">
                        @error('level_kode')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="level_nama">Level Nama</label>
                        <input type="text" class="form-control" id="level_nama" name="level_nama"
                            value="{{ $data->level_nama }}">
                        @error('level_nama')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
