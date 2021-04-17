@component('components.modal', [
    'modal_id'     => 'modal-show-item-brand',
    'modal_title'  => 'lihat informasi merek',
])
    @slot('modal_body')
        <h5 id="show-item-brand-title"></h5>
        <div class="mt-lg" id="show-item-brand-description"></div>
    @endslot
    @slot('modal_button')
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('tutup')) }}</button>
    @endslot
@endcomponent
