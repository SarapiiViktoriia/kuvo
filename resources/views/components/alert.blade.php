<div class="alert {{ $context ? 'alert-' . $context : 'alert-default' }}">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ $slot }}
</div>
