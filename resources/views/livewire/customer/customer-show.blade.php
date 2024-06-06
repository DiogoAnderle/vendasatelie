    <x-card cardTitle="Detalhes do Cliente">
        <x-slot:cardTools>
            <a href="{{ route('customers') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Voltar</a>
        </x-slot:cardTools>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center"># {{ $customer->id }} - {{ $customer->name }}</h3>
                        <p class="text-muted text-center">
                            {{ $customer->occupation }}
                        </p>

                        <ul class="list-group mb-3">
                            <li class="list-group-item">
                                <b>E-mail:</b> <a class="float-right text-white">{{ $customer->email }}</a>
                            </li>

                            <li class="list-group-item">
                                <b>Telefone:</b>
                                @if ($customer->phone_number)
                                    <a class="float-right text-white">{{ $customer->phone_number }}</a>
                                @else
                                    <a class="float-right text-white">Não informado</a>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Data de Nascimento:</b>
                                @if ($customer->phone_number)
                                    <a
                                        class="float-right text-white">{{ date('d/m/Y', strtotime($customer->birth_date)) }}</a>
                                @else
                                    <a class="float-right text-white"></a>
                                @endif
                            </li>

                            <li class="list-group-item">
                                <b>Data de Cadastro:</b> <a
                                    class="float-right text-white">{{ date('d/m/Y', strtotime($customer->created_at)) }}</a>
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


                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
