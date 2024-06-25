<div>
    <x-card cardTitle="Bem vind@s" cardFooter="">
        <x-slot:cardTools>
            <a href="{{ route('sales.list') }}" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-shopping-cart"></i> Ir a vendas
            </a>
            <a href="{{ route('sales.create') }}" class="btn bg-purple" wire:click='create'>
                <i class="fas  fa-cart-plus"></i> Criar venda
            </a>

        </x-slot:cardTools>

        {{-- card sales --}}
        @include('livewire.home.row-cards-sales')

        {{-- card graph --}}
        @include('livewire.home.card-graph')

        {{-- boxes reportes --}}
        @include('livewire.home.boxes-reports')

        {{-- table reportes --}}
        @include('livewire.home.tables-reports')

        {{-- Best sellers and buyers --}}
        @include('livewire.home.best-sellers-buyers')

    </x-card>

</div>
