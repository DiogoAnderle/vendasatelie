<div class="row">
    <div class="col-12">
        <h2 class="title">Geral de vendas</h2>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $salesQuantity }}</h3>
                <p>Vendas</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $totalSales }}</h3>

                <p>Total de vendas</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-check-alt"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $itemsQuantity }}</h3>

                <p>Itens Vendidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $productsQuantity }}</h3>

                <p>Produtos Vendidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-tshirt"></i>
            </div>
            <a href="{{ route('products') }}" class="small-box-footer"
                >Ir aos produtos <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>
</div>
<!-- SEGUNDA FILA -->
<div class="row">
    <div class="col-12">
        <h2 class="title">Vendas no Mês</h2>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $monthSalesQuantity }}</h3>
                <p>Vendas</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $monthTotalSales }}</h3>

                <p>Total de vendas</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-check-alt"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $monthItemsQuantity }}</h3>

                <p>Itens Vendidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <a href="{{ route('sales.list') }}" class="small-box-footer"
                >Ir para vendas <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $monthProductsSalesQuantity }}</h3>

                <p>Produtos Vendidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-tshirt"></i>
            </div>
            <a href="{{ route('products') }}" class="small-box-footer"
                >Ir aos produtos <i class="fas fa-arrow-circle-right"></i
            ></a>
        </div>
    </div>
</div>

<!-- TERCEIRA FILA -->

<div class="row">
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"
                ><i class="fas fa-tshirt"></i
            ></span>

            <div class="info-box-content">
                <span class="info-box-text">Produtos</span>
                <span class="info-box-number">
                    {{ $productsQuantity }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->


    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"
                ><i class="fas fa-th"></i
            ></span>

            <div class="info-box-content">
                <span class="info-box-text">Categorias</span>
                <span class="info-box-number"> {{ $categoriesQuantity }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"
                ><i class="fas fa-users"></i
            ></span>

            <div class="info-box-content">
                <span class="info-box-text">Clientes</span>
                <span class="info-box-number"> {{ $customersQuantity }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
