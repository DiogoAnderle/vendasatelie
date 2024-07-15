@props(['modalTitle' => '', 'modalId' => '', 'modalSize' => ''])
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog {{ $modalSize }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modalTitle }}</h5>
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
