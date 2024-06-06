<div class="position-relative">
    <form>
        <div class="input-group">
            <input wire:model.live='search' type="search" class="form-control" id="searchNavbar"
                placeholder="Buscar Produto...">
            <div class="input-group-append">
                <button class="btn btn-default" wire:click.prevent>
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <ul class="list-group position-absolute"id="list-search">
        @foreach ($products as $product)
            <li class="list-group-item">
                <h5>
                    <a class="text-white" href="{{ route('products.show', $product) }}">
                        <x-image :item="$product" size="50"></x-image>
                        {{ $product->name }}</a>
                </h5>
                <div class="d-flex justify-content-between">
                    <div class="mr-2"><b>Preço venda:</b>
                        <span class="badge badge-pill badge-info"> {!! $product->price !!}</span>
                    </div>
                    <div>Estoque:
                        <span> {!! $product->stockLabel !!}</span>
                    </div>
                </div>
            </li>
        @endforeach

    </ul>
</div>
