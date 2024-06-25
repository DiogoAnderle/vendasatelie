<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Melhores vendedores</b></h3>
                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($bestSellers as $user)
                        <li>
                            <x-image :item="$user" />
                            <a href="{{ route('users.show', $user) }}" class="users-list-name">{{ $user->name }}</a>
                            <span>{{ currencyBRLFormat($user->total) }}</span>
                        </li>
                    @endforeach

                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="{{ route('users') }}">Ir a usuarios</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Melhores clientes</b></h3>
                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @foreach ($bestBuyers as $customer)
                        <li>
                            <i class="fas fa-user-tie" style="font-size: 3rem"></i>
                            <a href="{{ route('customers.show', $customer) }}"
                                class="users-list-name mt-2">{{ $customer->name }}</a>
                            <span>{{ currencyBRLFormat($customer->total) }}</span>
                        </li>
                    @endforeach

                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="{{ route('customers') }}">Ir a clientes</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
