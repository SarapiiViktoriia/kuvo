@component('components.modal', [
    'modal_id'     => 'modal-show-item-group',
    'modal_title'  => 'detail informasi kategori produk',
])
    @slot('modal_body')
        <h5 id="show-item-group-title"></h5>
        <div class="mt-lg" id="show-item-group-description"></div>
    @endslot
    @slot('modal_button')
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('tutup')) }}</button>
    @endslot
@endcomponent
