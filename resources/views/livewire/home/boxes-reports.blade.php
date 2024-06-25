<div class="row">
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
            <a href="" class="small-box-footer">Ir para as ventas <i class="fas fa-arrow-circle-right"></i></a>
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
            <a href="" class="small-box-footer">Ir para vendas <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $itemsQuantity }}</h3>

                <p>Items Vendidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <a href="" class="small-box-footer">Ir a ventas <i class="fas fa-arrow-circle-right"></i></a>
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
            <a href="" class="small-box-footer">Ir a productos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- SEGUNDA FILA -->

<div class="row">
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tshirt"></i></span>

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
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-basket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Estoque total</span>
                <span class="info-box-number"> {{ $stockQuantity }}</span>
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
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th"></i></span>

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
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

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
