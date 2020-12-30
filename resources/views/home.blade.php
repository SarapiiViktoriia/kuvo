<<<<<<< HEAD
@extends('layouts.dashboard')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        @component('components.dashboard-panel',
        ['panel_context' => '',
        'panel_title'    => '',
        'panel_subtitle' => '',
        'panel_footer'   => ''])
            <div class="col-md-4 col-lg-3">
                <div class="thumb-info mb-md">
                    <img src="{{ asset('assets/images/!logged-user.jpg') }}" alt="" class="rounded img-responsive">
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
                <a href="#" class="btn btn-default btn-block">Edit Profil</a>
            </div>
            <div class="col-md-8 col-lg-9"></div>
        @endcomponent
    </div>
@endsection
=======
@extends('layouts.template', ['header' => 'Dashboard'])
>>>>>>> user-management
