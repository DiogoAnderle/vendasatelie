<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cart-plus"></i>
            Detalhes da venda
        </h3>
        <div class="card-tools">
            <!-- Products count -->
            <i class="fas fa-tshirt" title="Numero productos"></i>
            <span class="badge badge-pill bg-purple">{{ $cart->count() }} </span>
            <!-- Articles count -->
            <i class="fas fa-shopping-basket ml-2" title="Numero items"></i>
            <span class="badge badge-pill bg-purple">{{ $totalItems }} </span>

            <button wire:click="{{ isset($sale) ? 'editSale' : 'createSale' }}" class="btn bg-purple btn-sm ml-2">
                <i class="fas fa-cart-plus"></i> {{ isset($sale) ? 'Editar Venda' : 'Criar Venda' }}
            </button>
        </div>
    </div>
    <!-- card-body -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><i class="fas fa-image"></i></th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço.vd</th>
                        <th scope="col" width="15%">Qtd</th>
                        <th scope="col">Sub total</th>
                        <th scope="col">Ação</th>
                    </tr>

                </thead>
                <tbody>
                    @forelse ($cart as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <x-image :item="$product->associatedModel" size="40" />
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{!! currencyBRLFormat($product->price) !!}</td>
                            <td>
                                <div wire:ignore>
                                    <input type="number" min="1" class="form-control text-center w-auto border-0"
                                        wire:change.defer="updateQuantity({{ $product['id'] }}, $event.target.value)"
                                        wire:model.lazy="quantities.{{ $product['id'] }}" value="{{ $product['quantity'] }}"
                                        id="quantityInput_{{ $product['id'] }}" />
                                </div>
                            </td>
                            <td>{{ currencyBRLFormat($product->quantity * $product->price) }}</td>
                            <td>
                                <!-- Boton para eliminar el producto del carrito -->
                                <button wire:click="removeItem({{ $product->id }}, {{ $product->quantity }})"
                                    class="btn btn-danger btn-xs" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">Carrinho vazio</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="4"></td>
                        <td>
                            <h5>Total:</h5>
                        </td>
                        <td>
                            <h5>
                                <span class="badge badge-pill badge-secondary">
                                    {!! currencyBRLFormat($total) !!}</span>
                            </h5>
                        </td>
                        <td></td>
                    </tr>
                    <tr>

                        @if ($total)
                            <td colspan="7">
                                <strong>Total por extenso:</strong>
                                {{ numbersInFull($total) }}
                            </td>
                        @else
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- end-card-body -->
</div>