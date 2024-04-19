@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Pengelola</label>
                    <div class="col-11">
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Pilih Pengelola -</option>
                            @foreach($users as $item)
                                <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Penjualan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
                               value="{{ $kode }}" required>
                        @error('penjualan_kode')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Pembeli</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli') }}"
                               required>
                        @error('pembeli')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
                    <div class="col-11">
                        <input type="datetime-local" class="form-control" id="penjualan_tanggal"
                               name="penjualan_tanggal"
                               value="{{ old('penjualan_tanggal') }}" required>
                        @error('penjualan_tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-11 control-label col-form-label text-center">- Detail Penjualan -</label>
                </div>
                <div id="details" style="height: 25vh; overflow-y: auto; overflow-x: hidden">
                    <div class="detail-penjualan0 mb-2">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Nama Barang</label>
                            <div class="col-11">
                                <select class="form-control" name="barang_id[]" required>
                                    <option value="">- Pilih Barang -</option>
                                    @foreach($barangs as $item)
                                        <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                    @endforeach
                                </select>
                                @error('barang_id.*')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Jumlah Barang</label>
                            <div class="col-11">
                                <input type="text" class="form-control" name="jumlah[]" value="{{ old('jumlah') }}"
                                       required>
                                @error('jumlah.*')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeData(0)">Hapus
                        </button>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-11 offset-1">
                        <button type="button" class="btn btn-success btn-sm" id="add-detail">Tambah Detail Penjualan
                        </button>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function removeData(id) {
            $('.detail-penjualan' + id).remove();
        }

        $(document).ready(function () {
            let i = 1;
            $('#add-detail').click(function () {
                i++;
                let detailPenjualanHtml = `
            <div class="detail-penjualan${i} mb-2">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Barang</label>
                    <div class="col-11">
                        <select class="form-control" name="barang_id[]" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barangs as $item)
                <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                            @endforeach
                </select>
@error('barang_id.*')
                <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Jumlah Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="jumlah[]" value="{{ old('jumlah') }}" required>
                        @error('jumlah.*')
                <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeData(` + i + `)">Hapus</button>
        </div>
`;
                $('#details').append(detailPenjualanHtml);
            });
            $
        });

    </script>
@endpush
