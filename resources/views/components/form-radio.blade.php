<div class="form-group mb-lg">
        <div class="radio-custom">
            <input type="radio" name="{{ $name }}" id="{{ $name }}" {{ $disabled ? 'disabled' : '' }}>
            <label for="{{ $name }}">{{ $label }}</label>
            @if ($help_text)
                <p class="help-text">{{ $help_text }}</p>
            @endif
        </div>
    </div>
