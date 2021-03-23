@extends('layouts.dashboard')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <section class="panel">
                <div class="panel-body">
                    <p>
                        Terdapat <strong>{{ \App\Models\Item::count() }} produk</strong>
                        yang terdaftar dalam sistem.
                    </p>
                    <p>
                        Buka halaman <a href="{{ route('items.index') }}"><span class="fa fa-chevron-right"></span> daftar produk</a>
                        untuk melihat semua produk yang sudah kamu daftarkan.
                    </p>
                    <hr>
                    <a href="{{ route('items.index') }}" class="btn btn-default pull-right">
                        <span class="fa fa-chevron-right"></span> Lihat daftar produk
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection
