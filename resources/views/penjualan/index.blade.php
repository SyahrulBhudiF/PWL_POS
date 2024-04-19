@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pengelola</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm w-100" id="table_penjualan">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengelola</th>
                    <th>Pembeli</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Total</th>
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
            let dataPenjualan = $('#table_penjualan').DataTable({
                serverSide: true, // True if we want to use Server side processing
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.user_id = $('#user_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex", // numbering from laravel datatables addIndexColumn() function
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "user.nama",
                        className: "text-center",
                        orderable: false,	// orderable: false, if we want this column not orderable
                        searchable: false	// searchable: false, if we want this column not searchable
                    },
                    {
                        data: "pembeli",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "penjualan_kode",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "penjualan_tanggal",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "total",
                        className: "text-center",
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
            $('#user_id').on('change', function () {
                dataPenjualan.ajax.reload();
            });
        });
    </script>
@endpush
