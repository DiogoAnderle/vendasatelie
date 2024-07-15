    @if(count($salesInProgress) > 0)
    <div class="col-12">
        <h3>Pedidos em Andamento ({{count($salesInProgress)}})</h3>
    </div>
    @endif
    @foreach($salesInProgress as $sale)
    <div class="col-lg-2 col-md-6 col-sm-6 text-center">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h4><a class="text-dark" href="{{ route('sales.show', $sale) }}">{{ $sale->customer->name }} -  FV-{{ $sale->id }}</a>
            </h4>
               
                @forelse ($sale->items as $product)
                    <span class="text-limit d-flex position-relative">{{ ++$loop->index }}º Item: {{ $product->quantity }} {{ $product->name }}</span>
                @empty

                @endforelse
            </div>
            <hr style="padding: 0px; margin: 0px;">
            <a wire:click="$dispatch('finished',{id: {{ $sale->id }}, eventName:'finishSale'})"
                class="btn" title="Concluir Pedido">
                {!! $sale->statusLabel !!} Finalizar Pedido
            </a>
        </div> 
    </div>
    @endforeach

