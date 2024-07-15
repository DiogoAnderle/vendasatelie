<div>
    <x-card cardTitle="Criar Venda">
        <x-slot:cardTools>
            @if (isAdmin())
                <a href="{{ route('sales.list') }}" class="btn btn-sm btn-primary mr-2">
                    <i class="fas fa-shopping-cart"></i> Ir para as Vendas
                </a>
            @endif

            <a href="#" class="btn btn-sm btn-danger" wire:click='clear'>
                <i class="fas fa-trash"></i> Cancelar Venda
            </a>

           

        </x-slot>

        {{-- Main Content --}}
        <div class="row">
            {{-- Sales Detail --}}
            <div class="col-md-6">
              
                {{-- Cart Details --}}
                @include('livewire.sale.cart-details')
                {{-- Customer --}}
                @livewire('sale.customer-sale')

                {{-- Payment --}}
                @include('livewire.sale.payment-card')
                {{-- Status --}}
                @include('livewire.sale.sale-status')
            </div>
            {{-- Products --}}
            <div class="col-md-6">
                @include('livewire.sale.products-list')
                
            </div>
        </div>
    </x-card>


</div>
