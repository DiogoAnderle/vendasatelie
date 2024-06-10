<x-modal modalId="modalShop" modalTitle="Datos tienda" modalSize="modal-lg">
    <form wire:submit="update">

        <div class="form-row">

            {{-- Input Name --}}
            <div class="form-group col-md-7">
                <label for="name">Nombre:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nombre tienda" id="name">
                @error('name')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Slogan --}}
            <div class="form-group col-md-5">
                <label for="cnpj">CNPJ:</label>
                <input wire:model='cnpj' type="text" class="form-control" placeholder="cnpj tienda" id="cnpj">
                @error('cnpj')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Telefono --}}
            <div class="form-group col-md-5">
                <label for="phone_number">Telefone:</label>
                <input wire:model='phone_number' type="text" class="form-control" placeholder="phone_number tienda"
                    id="phone_number">
                @error('phone_number')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>


            {{-- Input Telefono --}}
            <div class="form-group col-md-7">
                <label for="email">Email:</label>
                <input wire:model='email' type="email" class="form-control" placeholder="Email tienda" id="email">
                @error('email')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Direccion --}}
            <div class="form-group col-md-5">
                <label for="address">Endereço:</label>
                <input wire:model='address' type="text" class="form-control" placeholder="address tienda"
                    id="address">
                @error('address')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Ciudad --}}
            <div class="form-group col-md-7">
                <label for="city">Cidade:</label>
                <input wire:model='city' type="text" class="form-control" placeholder="city tienda" id="city">
                @error('city')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="slogan">Slogan:</label>
                <input wire:model='slogan' type="text" class="form-control" placeholder="Slogan tienda"
                    id="slogan">
                @error('slogan')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input imagen --}}
            <div class="form-group col-md-6">

                <label for="image">Imagem:</label>
                <input wire:model='image' type="file" id="image" accept="image/*">

                @error('image')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- imagen --}}

            <div class="form-group col-md-12">
                @if ($Id > 0)
                    <div class="d-flex justify-content-around">
                        <span>Imagem Atual</span>
                        <x-image :item="$shop" size="150" />
                    </div>
                @endif

                @if ($this->image)
                    <hr>
                    <div class="d-flex justify-content-around">
                        <span>Imagem Nova</span>
                        <img src="{{ $image->temporaryUrl() }}" alt="User Image" width="150" class="rounded">
                    </div>
                @endif
            </div>


        </div>

        <hr>
        <button wire:loading.attr='disabled' class="btn btn-primary float-right">
            Editar
        </button>

    </form>
</x-modal>
