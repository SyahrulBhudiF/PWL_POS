@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function () {
            let dataUser = $('#table_level').DataTable({
                serverSide: true, // True if we want to use Server side processing
                ajax: {
                    "url": "{{ url('kategori/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    {
                        data: "DT_RowIndex", // numbering from laravel datatables addIndexColumn() function
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kategori_kode",
                        className: "",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "kategori_nama",
                        className: "",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,	// orderable: false, if we want this column not orderable
                        searchable: false	// searchable: false, if we want this column not searchable
                    }
                ]
            });
        });
    </script>
@endpush
