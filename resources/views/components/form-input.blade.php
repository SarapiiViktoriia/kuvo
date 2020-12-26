<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label {{ $required ? 'text-primary' : '' }}">{{ $label }} {{ $required ? '*' : '' }}</label>
    @if ($static)
        <p class="form-control-static"><mark>{{ $value }}</mark></p>
    @else
        @if ($icon)
            <div class="input-group {{ $icon ? 'input-group-icon' : '' }} col-md-12">
                <span class="input-group-addon">
                    <span class="icon">
                        <i class="fa fa-{{ $icon }}"></i>
                    </span>
                </span>
        @endif
        <input type="{{ $type }}" class="form-control" name="{{ $name }}" id="{{ $name }}" {{ $value ? 'value=' . $value : '' }} {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }} {{ $disabled ? 'disabled' : '' }}>
        @if ($help_text)
            <p class="help-text">{{ $help_text }}</p>
        @endif
        @if ($icon)
            </div>
        @endif
    @endif
</div>
