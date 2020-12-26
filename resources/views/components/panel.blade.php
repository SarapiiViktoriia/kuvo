<section class="panel {{ $context ? 'panel-' . $context : '' }}">
    @if ($panel_title)
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
            </div>
            <h3 class="panel-title">{{ $panel_title }}</h3>
        </header>
    @endif
    <div class="panel-body">
        {{ $slot }}
    </div>
</section>
