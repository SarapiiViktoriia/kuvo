@extends('layouts.dashboard')
@section('content')
    <div class="jumbotron">
        <p>Untuk menjaga konsistensi tampilan aplikasi, silakan gunakan komponen-komponen berikut
            untuk aplikasi yang kamu kembangkan.
        </p>
    </div>
    @component('components.panel',
    ['panel_title' => 'Contoh Komponen Form',
    'context'      => ''])
        <form action="#">
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan teks',
            'value' => '',
            'icon'  => '',
            'help_text' => '',
            'required' => '',
            'autofocus' => '',
            'disabled' => '',
            'static' => ''])
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan autofokus',
            'value' => '',
            'icon'  => '',
            'help_text' => '',
            'required' => '',
            'autofocus' => true,
            'disabled' => '',
            'static' => ''])
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan diharuskan',
            'value' => '',
            'icon'  => '',
            'help_text' => '',
            'required' => true,
            'autofocus' => '',
            'disabled' => '',
            'static' => ''])
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan dengan bantuan',
            'value' => '',
            'icon'  => '',
            'help_text' => 'Silakan diisi dengan baik dan benar.',
            'required' => '',
            'autofocus' => '',
            'disabled' => '',
            'static' => ''])
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan disable',
            'value' => '',
            'icon'  => '',
            'help_text' => '',
            'required' => '',
            'autofocus' => '',
            'disabled' => true,
            'static' => ''])
            @include('components.form-input',
            ['type' => 'text',
            'name' => 'text_input',
            'label' => 'Masukan dengan ikon',
            'value' => '',
            'icon'  => 'user',
            'help_text' => '',
            'required' => '',
            'autofocus' => '',
            'disabled' => '',
            'static' => ''])
            @include('components.form-input',
            ['type'     => 'text',
            'name'      => 'valued_text_input',
            'label'     => 'Masukan dengan nilai',
            'value'     => 'Nilainya',
            'icon'      => '',
            'help_text' => '',
            'required'  => '',
            'autofocus' => '',
            'disabled'  => '',
            'static'    => ''])
            @include('components.form-input',
            ['type'     => 'text',
            'name'      => 'static_text_input',
            'label'     => 'Masukan statik',
            'value'     => 'Nilainya',
            'icon'      => '',
            'help_text' => '',
            'required'  => '',
            'autofocus' => '',
            'disabled'  => '',
            'static'    => true])
            @include('components.form-checkbox',
            ['name'     => 'checkbox',
            'label'     => 'Checkbox',
            'help_text' => '',
            'disabled'  => ''])
            @include('components.form-radio',
            ['name'     => 'radiobox',
            'label'     => 'Radio',
            'help_text' => '',
            'disabled'  => ''])
            @include('components.form-textarea',
            ['name' => 'textarea',
            'label' => 'Area teks'])
        </form>
    @endcomponent
    @component('components.panel',
    ['panel_title' => 'Contoh Alert',
    'context'      => ''])
        @component('components.alert', ['context' => ''])
            <p>Ini adalah alert.</p>
        @endcomponent
    @endcomponent
@endsection
