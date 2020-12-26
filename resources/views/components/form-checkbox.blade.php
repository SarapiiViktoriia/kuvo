<div class="form-group mb-lg">
    <div class="checkbox-custom checkbox-default">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" {{ $disabled ? 'disabled' : '' }}>
        <label for="{{ $name }}">{{ $label }}</label>
        @if ($help_text)
            <p class="help-text">{{ $help_text }}</p>
        @endif
    </div>
</div>
