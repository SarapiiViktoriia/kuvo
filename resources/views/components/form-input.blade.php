<div class="form-group mb-lg">
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="input-group input-group-icon">
        <span class="input-group-addon">
            <span class="icon icon-lg">
                <i class="fa fa-{{ $icon }}"></i>
            </span>
        </span>
        <input type="{{ $type }}" class="form-control input-lg" name="{{ $name }}">
    </div>
</div>
