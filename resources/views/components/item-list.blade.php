<div class="col-sm-9">
    <select name="" id="" class="form-control">
        <option value="">Pilih produk ...</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</div>
<div class="col-sm-3">
    <div data-plugin-spinner data-plugin-options="{ 'value': 0, 'min': 0 }">
        <div class="input-group">
            <input type="text" class="spinner-input form-control">
            <div class="spinner-buttons input-group-btn">
                <button type="button" class="btn btn-default spinner-up">
                    <i class="fa fa-angle-up"></i>
                </button>
                <button type="button" class="btn btn-default spinner-down">
                    <i class="fa fa-angle-down"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<br>
