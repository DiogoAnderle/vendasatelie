<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <b>Produtos mais vendidos hoje</b>
                </h3>
                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Preço venda</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bestSaleProductsToday as $product)
                                <tr>
                                    <td>{{ $product->product_id }}</td>
                                    <td>
                                        <img src="{{ asset($product->image) }}" width="50px"
                                            class="img-fluid rounded">


                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ currencyBRLFormat($product->price) }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->total_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ currencyBRLFormat($product->price * $product->total_quantity) }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10">
                                        Sem registros.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col-md-6 -->
    <!--.col-md-6 -->
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <b>Produtos mais vendidos este mês</b>
                </h3>

                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Preço venda</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($bestSaleProductsMonth as $product)
                                <tr>
                                    <td>{{ $product->product_id }}</td>
                                    <td>
                                        <img src="{{ asset($product->image) }}" width="50px"
                                            class="img-fluid rounded">


                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ currencyBRLFormat($product->price) }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->total_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ currencyBRLFormat($product->price * $product->total_quantity) }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10">
                                        Sem registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col-md-6 -->

    <!-- /.row -->

    {{-- SEGUNDA FILA --}}


    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <b>
                        Produtos mais vendidos
                    </b>
                </h3>

                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Preço venda</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bestSaleProducts as $product)
                                <tr>
                                    <td>{{ $product->product_id }}</td>
                                    <td>
                                        <img src="{{ asset($product->image) }}" width="50px"
                                            class="img-fluid rounded">


                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ currencyBRLFormat($product->price) }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->total_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ currencyBRLFormat($product->price * $product->total_quantity) }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10">
                                        Sem registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <b>
                        Produtos cadastrados recentemente
                    </b>
                </h3>

                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Preço venda</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($recentProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <x-image :item="$product" size="50" />


                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->price !!}</td>


                                </tr>

                            @empty
                                <tr>
                                    <td colspan="10">
                                        Sem registros.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
