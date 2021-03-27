@component('components.modal', [
    'modal_id'    => 'modal-show-item',
    'modal_title' => 'detil informasi produk',
    'modal_body'  => ''
])
    @slot('modal_button')
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ ucwords(__('tutup')) }}</button>
    @endslot
@endcomponent
