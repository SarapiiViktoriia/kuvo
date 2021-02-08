@component('components.modal',
['modal_id'   => 'modal-show-item',
'modal_title' => 'Detail',
'modal_body'  => ''])
    @slot('modal_button')
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ ucwords(__('tutup')) }}</button>
    @endslot
@endcomponent
