    <x-card cardTitle="Detalhes da Categoria">
        <x-slot:cardTools>
            <a href="{{ route('categories') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Voltar</a>
        </x-slot:cardTools>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">#{{ $category->id }} - {{ $category->name }}</h3>

                        <ul class="list-group mb-3">
                            <li class="list-group-item">
                                <b>Produtos</b> <a class="float-right">{{ count($category->products) }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Artigos</b> <a class="float-right">{{ $products->sum('stock') }}</a>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>
            <div class="col-md-8">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Preço Venda</th>
                            <th>Estoque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <x-image :item="$product"></x-image>
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{!! $product->price !!}</td>
                                <td>{!! $product->stockLabel !!}</td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </x-card>
