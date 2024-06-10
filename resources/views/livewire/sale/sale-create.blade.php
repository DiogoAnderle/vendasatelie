<div>
    <x-card cardTitle="Criar Venda">
        <x-slot:cardTools>

            <a href="{{ route('sales.list') }}" class="btn btn-sm btn-primary mr-2">
                <i class="fas fa-shopping-cart"></i> Ir para as Vendas
            </a>

            <a href="#" class="btn btn-sm btn-danger" wire:click='clear'>
                <i class="fas fa-trash"></i> Cancelar Venda
            </a>

        </x-slot>

        {{-- Main Content --}}
        <div class="row">
            {{-- Sales Detail --}}
            <div class="col-md-6">
                {{-- Customer --}}
                @livewire('sale.customer-sale')
                {{-- Cart Details --}}
                @include('livewire.sale.cart-details')

                {{-- Payment --}}
                @include('livewire.sale.payment-card')
            </div>
            {{-- Products --}}
            <div class="col-md-6">
                @include('livewire.sale.products-list')
            </div>
        </div>

        <x-slot:cardFooter>

        </x-slot>
    </x-card>

</div>
