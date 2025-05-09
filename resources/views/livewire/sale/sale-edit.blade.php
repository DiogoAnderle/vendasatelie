<div>
    <x-card cardTitle="Editar Venda">
        <x-slot:cardTools>
            @if (isAdmin())
                <a href="{{ route('sales.list') }}" class="btn btn-sm btn-primary mr-2">
                    <i class="fas fa-shopping-cart"></i> Ir para as Vendas
                </a>
            @endif
        </x-slot>

        {{-- Main Content --}}
        <div class="row">
            {{-- Sales Detail --}}
            <div class="col-md-6">
                {{-- Cart Details --}}
                @include('livewire.sale.cart-details')

                <livewire:sale.customer-sale :customerId="$sale->customer_id" />

                @include('livewire.sale.payment-card')
                {{-- Status --}}
                @include('livewire.sale.sale-status')
                {{-- Status --}}
                @include('livewire.sale.order-notes')


            </div>
            {{-- Products --}}
            <div class="col-md-6">
                @include('livewire.sale.products-list')
            </div>
        </div>


    </x-card>

</div>
