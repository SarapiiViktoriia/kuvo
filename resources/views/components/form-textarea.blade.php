<div class="form-group mb-lg">
    <label for="{{ $name }}" class="control-label">{{ $label }}</label>
    <div class="input-group col-md-12">
        <textarea name="{{ $name }}" id="{{ $name }}" rows="5" class="form-control" data-plugin-textarea-autosize></textarea>
    </div>
</div>
@push('vendorscripts')
    <script src="{{ asset('assets/vendor/jquery-autosize/jquery.autosize.js') }}"></script>
@endpush
