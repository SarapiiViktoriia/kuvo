@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
    <p class="lead">
        Di sini kamu dapat melihat informasi stok produk yang kamu miliki.
    </p>
    @component('components.panel', [
        'context'     => '',
        'panel_title' => 'stok produk'
    ])
        @component('components.datatable-ajax', [
            'table_id'      => 'stocks',
            'table_headers' => ['kategori produk', 'merek produk', 'nama produk', 'stok'],
            'condition'     => false,
            'data'          => [
                ['name' => 'itemGroup.name', 'data' => 'item_group.name'],
                ['name' => 'itemBrand.name', 'data' => 'item_brand.name'],
                ['name' => 'name', 'data' => 'name'],
                ['name' => 'stock', 'data' => 'stock'],
            ]
        ])
            @slot('data_send_ajax')
            @endslot
        @endcomponent
    @endcomponent
@endsection
@push('vendorstyles')
	<link href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/vendor/select2/select2.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('vendorscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}" type="text/javascript"></script>
@endpush
