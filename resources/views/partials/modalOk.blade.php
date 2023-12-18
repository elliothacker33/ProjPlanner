@php
    $icons = array(
        'modal-error' => 'fa-circle-exclamation',
        'modal-warning' => 'fa-triangle-exclamation',
        'modal-info' => 'fa-circle-info',
        'modal-success' => 'fa-circle-check',
    )
@endphp

<dialog class="modal {{ $type }}" data-open-form-id="{{ $openFormId }}">
    <div class="modal-header">
        <div class="icon-title-wrapper">
            <i class="fa-solid {{ $icons[$type] }}"></i>
            <h3> {{ $modalTitle }}</h3>
        </div>
        <i class="fa-solid fa-x"></i>
    </div>
    <div class="modal-body">
        <p> {{ $modalBody }}</p>
    </div>
</dialog>