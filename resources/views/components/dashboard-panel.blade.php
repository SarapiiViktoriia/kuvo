<section class="panel {{ $panel_context }}">
    @if ($panel_title)
        <header class="panel-heading">
            <h2 class="panel-title">{{ $panel_title }}</h2>
            @if ($panel_subtitle)
                <p class="panel-subtitle">{{ $panel_subtitle }}</p>
            @endif
        </header>
    @endif
    <div class="panel-body">
        <div class="thumb-info mb-md">
            {{ $slot }}
        </div>
    </div>
    @if ($panel_footer)
        <div class="panel-footer">
            {{ $panel_footer }}
        </div>
    @endif
</section>
