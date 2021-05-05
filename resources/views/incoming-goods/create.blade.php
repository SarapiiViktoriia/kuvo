@extends('layouts.dashboard', ['page_title' => 'pencatatan kedatangan barang'])
@section('content')
    <form action="{{ route('incoming-goods.store') }}" method="post" id="incoming-good-form">
        @csrf
        <div class="form-group mt-lg" id="div-company">
            <label for="company" class="col-sm-3 control-label text-right">Supplier</label>
            <div class="col-sm-9">
                <select name="supplier_id" id="" class="form-control">
                    <option value="">Pilih supplier ...</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group mt-lg" id="div-arrival_date">
            <label for="arrival_date" class="col-sm-3 control-label text-right">Tanggal masuk</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control" name="arrival_date" id="arrival_date">
                </div>
            </div>
        </div>
        <div class="form-group mt-lg" id="div-items">
            <label for="items" class="col-sm-3 control-label text-right">Daftar produk masuk</label>
            <div class="col-sm-9" id="item-list">
                <button type="button" class="btn btn-primary" id="add-item">
                    <span class="fa fa-plus"></span>
                    {{ ucwords(e(__('tambah produk'))) }}
                </button>
                <div class="panel mt-md">
                    <div class="panel-body table-responsive">
                        <table class="table mb-md">
                            <thead>
                                <tr>
                                    <th>{{ strtoupper(e(__('nama produk'))) }}</th>
                                    <th>{{ strtoupper(e(__('jumlah'))) }}</th>
                                    <th class="text-right">{{ strtoupper(e(__('hpp'))) }}</th>
                                </tr>
                            </thead>
                            <tbody id="selected-item-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group mt-lg">
            <div class="col-md-9 col-md-offset-3 text-right">
                <button type="submit" class="btn btn-primary" id="incoming-goods-submit-button"><span class="fa fa-save"></span> {{ ucwords(__('simpan catatan')) }}</button>
            </div>
        </div>
    </form>
    @include('incoming-goods.add-item')
@endsection
@push('vendorstyles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}">
@endpush
@push('vendorscripts')
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/fuelux/js/spinner.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            /*
			 * Menggunakan select2 untuk semua pilihan.
			 */
            $('select').select2();
            /*
             * Mengaturan opsi penggunaan datepicker.
             */
            $('#arrival_date').datepicker({
                format:         'dd/mm/yyyy',
                endDate:        '0d',
                language:       'id-ID',
                todayBtn:       'linked',
                todayHighlight: true
            });
            /*
             * Mengatur nilai baku datepicker ketika dimuat pertama kali.
             */
            var date  = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#arrival_date').datepicker('setDate', today);
            /*
             * Menjalankan aksi yang diminta ketika tombol add-item
             * ditekan pengguna.
             */
            $('#add-item').click(function () {
                $('#choose-item-modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                clearForm($('#choose-item-form'));
            });
            /*
             * Memproses formulir penambahan produk ketika tombol
             * submit ditekan.
             */
            $('#choose-item-submit').click(function(e) {
                storeItem();
            });
            /*
             * Fungsi untuk membersihkan nilai yang dimiliki
             * setiap bidang pada sebuah form.
             */
            function clearForm($form)
            {
                $form.find('input:text, input:password, input:file, select, textarea').val([]);
                $form.find(':input[type=number]').val([]);
                $form.find('input:radio, input:checkbox').prop('checked', false);
                $form.find($('.select2-chosen')).text('');
            }
            /*
             * Fungsi untuk menyimpan data pilihan produk sehingga
             * dapat digunakan formulir pencatatan penerimaan produk.
             */
            function storeItem() {
                $.ajax({
                    method: "post",
                    url:    "{{ route('incoming-goods.choose-item') }}",
                    data:   $('#choose-item-form').serialize(),
                    success: function(response) {
                        $('#selected-item-list').append(response);
                    }
                });
                $('#choose-item-modal').modal('hide');
            }
            /*
             * Mengirim data pada form penambahan resource saat tombol sumbisi ditekan.
             */
             $('#incoming-goods-submit-button').click(function () {
                 var form = $('#incoming-good-form');
                 var data = form.serializeArray();
                $.each(data, function (key, value) {
                    if (value.name === 'arrival_date' && value.value !== '') {
                        value.value = moment(value.value, "DD/MM/YYYY").format("YYYY-MM-DD");
                    }
                })
                $.ajax({
                    url:    form.attr('action'),
                    method: form.attr('method'),
                    data:   data,
                    success: function (response) {
                        new PNotify({
                            type:  'success',
                            title: 'Berhasil',
                            text:  'Paket yang datang sudah dicatat dalam sistem.'
                        });g
                        Response.redirect('{{ route('stocks.index') }}');
                    },
                });
             })
        });
    </script>
@endpush
