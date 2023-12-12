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
        <button type="button" class="modal-confirm" id="{{ $actionId }}">Confirm</button>
    </div>
</dialog>