    <x-card cardTitle="Detalhes do produto">
        <x-slot:cardTools>

            <a wire:click="edit({{ $product->id }})"class="btn btn-info">
                <i class="far fa-edit"></i> Editar</a>


            @if (isAdmin())
            <a wire:click="$dispatch('delete',{id: {{ $product->id }},name:'{{ $product->name }}', eventName:'destroyProduct'})"
                class="btn btn-danger">
                <i class="far fa-trash-alt"></i> Excluir
            </a>
            @endif

            <a href="{{ route('products') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Voltar</a>
        </x-slot:cardTools>
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-5">
                        <div class="col-12">
                            <img src="{{ $product->imagem }}" class="product-image" alt="Product Image">
                        </div>

                    </div>
                    <div class="col-12 col-sm-7">
                        <h3 class="my-3">{{ $product->name }}</h3>
                        <p>{{ $product->description }}
                        </p>

                        <hr>

                        <div class="row">
                            <!-- Caja stock -->
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-box-open"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Estoque</span>
                                        <span class="info-box-number">{!! $product->stockLabel !!}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>

                            <!-- Caja stock minimo-->
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-box-open"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Estoque mínimo</span>
                                        <span class="info-box-number">
                                            <span class="badge badge-success">{{ $product->min_stock }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>

                            <!-- Caja categoria -->
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <div class="info-box-content">

                                        <span class="info-box-text">Categoria</span>
                                        <span class="info-box-number">{{ $product->category->name }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>

                            <!-- Caja estado -->
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-toggle-on"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Estado</span>
                                        <span class="info-box-number">{!! $product->activeLabel !!}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>

                            <!-- Caja fecha creacion -->
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Data de Cadastro </span>
                                        <span class="info-box-number">
                                            {{ date('d/m/Y', strtotime($product->created_at)) }}
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="bg-lightblue py-2 px-3 mt-4 col-md-6">
                                <h2 class="mb-0">
                                    R$ {{ number_format($product->purchase_price, 2, ',', '.') }}
                                </h2>
                                <h4 class="mt-0">
                                    <small>Preço venda </small>
                                </h4>
                            </div>
                            <div class="bg-gray py-2 px-3 mt-4 col-md-6">
                                <h2 class="mb-0">
                                    R$ {{ number_format($product->sale_price, 2, ',', '.') }}
                                </h2>
                                <h4 class="mt-0">
                                    <small>Preço compra</small>
                                </h4>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @include('livewire.product.modal')
    </x-card>
