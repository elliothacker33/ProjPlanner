<dialog class="modal" data-open-form-id="{{ $openFormId }}">
    <div class="modal-header">
        <h3> {{ $modalTitle }}</h3>
        <i class="fa-solid fa-x"></i>
    </div>
    <div class="modal-body">
        <p> {{ $modalBody }}</p>
    </div>
    <div class="modal-buttons">
        <a class="close-modal">Close</a>
        <button type="{{ isset($formId) ? "submit" : "button"}}" class="modal-confirm" 
            @isset ($actionId)
                id="{{ $actionId }}"
            @endisset 
            @isset ($formId)
                form="{{ $formId }}"
            @endisset
        >
            Confirm
        </button>
    </div>
</dialog>