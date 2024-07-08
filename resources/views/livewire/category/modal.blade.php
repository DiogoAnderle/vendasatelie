<x-modal modalId="modalCategory" modalTitle="{{ $Id == 0 ? 'Criar Categoria' : 'Editar Categoria' }}">
    <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
        <div class="form-row">
            <div class="form-group col mb-3">

                <label for="name" class="form-label">Categoria:</label>
                <input wire:model='name' type="text" class="form-control"id="name"
                    placeholder="Nome da categoria">
                @error('name')
                    <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary float-right">{{ $Id == 0 ? 'Salvar' : 'Editar' }}</button>
    </form>
</x-modal>