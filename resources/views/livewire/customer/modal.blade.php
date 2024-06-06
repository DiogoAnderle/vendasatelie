<x-modal modalId="modalCustomer" modalTitle="{{ $Id == 0 ? 'Cadastrar' : 'Editar' }}">
    <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
        <div class="form-row">

            {{-- Input Name --}}
            <div class="form-group col-md-6">
                <label for="name">Nome:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nome" id="name">
                @error('name')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Ocuppation --}}
            <div class="form-group col-md-6">
                <label for="occupation">Profissão:</label>
                <input wire:model='occupation' type="text" class="form-control" placeholder="Profissão"
                    id="occupation">
                @error('occupation')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- Input Email --}}
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input wire:model='email' type="email" class="form-control" placeholder="Nome" id="email">
                @error('email')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Phone Number --}}
            <div class="form-group col-md-6">
                <label for="phone_number">Telefone:</label>
                <input wire:model.debounce='phone_number'x-mask="(99)9 9999-9999" type="tel" class="form-control"
                    placeholder="Nome" id="phone_number">
                @error('phone_number')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            @if ($Id == 0)
                <div class="form-group col-md-6">
                    <label for="birth_date">Data de nascimento:</label>
                    <input wire:model='birth_date' type="date" class="form-control" id="birth_date">
                </div>
            @else
                <div class="form-group col-md-6">
                    <label for="birth_date">Data de nascimento:</label>
                    <input wire:model.debounce='birth_date' x-mask="99/99/9999" type="text" class="form-control"
                        id="birth_date">
                </div>
            @endif



        </div>

        <hr>
        <button class="btn btn-primary float-right">{{ $Id == 0 ? 'Salvar' : 'Editar' }}</button>
    </form>
</x-modal>
