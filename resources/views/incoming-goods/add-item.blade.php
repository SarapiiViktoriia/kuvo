@component('components.modal', [
    'modal_id'    => 'choose-item-modal',
    'modal_title' => 'pilih produk'
])
    @slot('modal_body')
        <form method="post" id="choose-item-form">
            @csrf
            <div class="form-group">
                <label for="product" class="control-label col-sm-3 text-right">{{ ucfirst(e(__('nama produk'))) }}</label>
                <div class="col-sm-9">
                    <select name="product" id="product" class="form-control">
                        <option value="">{{ ucfirst(e(__('pilih produk'))) }} ...</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="capital-price" class="control-label col-sm-3 text-right">{{ strtoupper(e(__('hpp'))) }}</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="number" id="capital-price" name="capital_price" class="form-control" required>
                        <span class="input-group-addon">,00</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="count" class="control-label col-sm-3 text-right">{{ ucfirst(e(__('jumlah'))) }}</label>
                <div class="col-sm-9">
                    <input type="number" name="count" id="count" class="form-control" required>
                </div>
            </div>
        </form>
    @endslot
    @slot('modal_button')
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
        <button type="submit" class="btn btn-primary" id="choose-item-submit"><span class="fa fa-edit"></span> {{ ucwords(__('catat')) }}</button>
    @endslot
@endcomponent
