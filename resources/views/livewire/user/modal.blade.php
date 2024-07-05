<x-modal modalId="modalUser" modalTitle="{{ $Id == 0 ? 'Cadastrar Usuário' : 'Editar Usuário' }}">
    <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
        <div class="form-row">
            {{-- Input Nome --}}
            <div class="form-group col-12 col-md-6">
                <label for="name">Nome:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nome" id="name">
                @error('name')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input E-mail --}}
            <div class="form-group col-12 col-md-6">
                <label for="email">E-mail:</label>
                <input wire:model='email' type="email" class="form-control" placeholder="example@email.com"
                    id="email">
                @error('email')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Senha --}}
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="password">Senha:</label>
                <input wire:model='password' type="password" class="form-control" placeholder="Senha" id="password">
                <i class="fas fa-eye position-absolute text-blue animate__animated " id="showPassord" style="top:60%; right:15px;"></i>
                @error('password')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Confirmar Senha --}}
            <div class="form-group col-12 col-md-6">
                <label for="re_password">Confirmar Senha:</label>
                <input wire:model='re_password' type="password" class="form-control" placeholder="Confirmar Senha"
                    id="re_password">
                @error('re_password')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input checkbox Admin --}}
            <div class="form-group form-check col-12 col-md-6">
                <div class="icheck-primary">
                    <input wire:model='admin' type="checkbox" class="form-control" id="admin">
                    <label for="admin">Administrador</label>
                </div>
            </div>

            {{-- Input checkbox Ativo --}}
            <div class="form-group form-check col-12 col-md-6">
                <div class="icheck-primary">
                    <input wire:model='active' type="checkbox" class="form-control" id="active" checked>
                    <label for="active">Ativo</label>
                </div>
            </div>

            {{-- Input File Imagem --}}
            <div class="form-group col-12 col-md-6">
                <label for="image">Imagem</label>
                <input wire:model='image' type="file" accept="image/*" id="image">
            </div>

            {{-- Preview da Imagem --}}
            <div class="form-group col-md-12">
                @if ($Id > 0)
                    <div class="d-flex justify-content-around">
                        <span>Imagem Atual</span>
                        <x-image :item="$user = App\Models\User::find($Id)" size="150" />
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
        <button class="btn btn-primary float-right">{{ $Id == 0 ? 'Salvar' : 'Editar' }}</button>
    </form>
</x-modal>
