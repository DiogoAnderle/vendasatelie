<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fatura de Venda</title>
    <style>
        .b {
            border: 1px solid black;
        }

        .shop-info {
            display: block;
            padding: 3px;
            font-size: 0.8rem;
        }

        .fatura-id {
            font-size: 1.5rem;
            font-style: normal;
            color: #525659;
        }

        .fatura-data {
            font-size: 1rem;
            font-style: normal;
            color: #525659;
        }

        .products {
            text-align: center;
            margin-top: 1rem;
        }

        .products thead {
            background-color: #084471ab;
            color: #fff
        }

        .products tr:nth-child(even) {
            background-color: #ddd;
        }

        th,
        td {
            padding: 10px;
        }

        .badge {
            background-color: #084471ab;
            width: 20px;
            color: #fff;
            padding: 5px;
            border-radius: 100%;
            font-weight: 500;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td width="25%">
                <img src="{{ public_path() . '/' . 'storage/' . $shop->image->url }}" alt="" srcset=""
                    width="200px">
            </td>
            <td width="45%" style="text-align: center;">
                <h1>{{ $shop->name }}</h1>
                @if ($shop->slogan)
                    <p>{{ $shop->slogan }}</p>
                @endif
            </td>
            <td width="30%">
                @if ($shop->phone_number)
                    <span class="shop-info"><b>Telefone:</b>{{ $shop->phone_number }}</span>
                @endif
                @if ($shop->email)
                    <span class="shop-info"><b>E-mail:</b>{{ $shop->email }}</span>
                @endif
                @if ($shop->address)
                    <span class="shop-info"><b>Endereço:</b>{{ $shop->address }}</span>
                @endif
                @if ($shop->city)
                    <span class="shop-info"><b>Cidade:</b>{{ $shop->city }}</span>
                @endif
            </td>
        </tr>

        <body>

        </body>
    </table>

    <table width="100%">
        <thead>
            <td width="33%">
                <h2 style="margin-bottom: .4rem;">Cliente</h2>
                <span class="shop-info"><b>Nome: </b>{{ $sale->customer->name }}</span>

                @if ($sale->customer->occupation)
                    <span class="shop-info"><b>Profissão: </b>{{ $sale->customer->occupation }}</span>
                @endif

                @if ($sale->customer->email)
                    <span class="shop-info"><b>E-mail: </b>{{ $sale->customer->email }}</span>
                @endif

                @if ($sale->customer->phone_number)
                    <span class="shop-info"><b>Telefone: </b>{{ $sale->customer->phone_number }}</span>
                @endif

                @if ($sale->customer->birth_date)
                    <span class="shop-info"><b>Data Nascimento: </b>
                        {{ date('d/m/Y', strtotime($sale->customer->birth_date)) }}</span>
                @endif

            </td>

            <td width="33%">
                <h2 style="text-align: center;">
                    Fatura: <span class="fatura-id">FV-{{ $sale->id }}</span>
                </h2>
            </td>
            <td width="33%">
                <h3>
                    Data: <span class="fatura-data">{{ date('d/m/Y H:i:s', strtotime($sale->created_at)) }}</span>
                </h3>
            </td>
            </tr>
    </table>

    <table width="100%" class="products">
        <thead>
            <th>#</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Items</th>
            <th>Subtotal</th>
        </thead>
        <tbody>
            @forelse ($sale->items as $item)
                <tr>
                    <td>{{ ++$loop->index }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ currencyBRLFormat($item->price) }}</td>
                    <td>
                        <div class="badge">{{ $item->quantity }}</div>
                    </td>
                    <td>{{ currencyBRLFormat($item->price * $item->quantity) }}</td>
                </tr>
            @empty
                <td colspan="5">Sem Registros</td>
            @endforelse
            <tr>
                <td colspan="3"></td>
                <td><b>Total:</b></td>
                <td><b>{{ currencyBRLFormat($sale->net_value) }}</b></td>
            </tr>

        </tbody>
    </table>

    <table width="100%" style="text-align: center; margin-top:5rem;">
        <tr>
            <td>
                __________________________________________ <br>
                <b>{{ $sale->user->name }}</b> <br>
                Vendedor
            </td>
        </tr>
    </table>
    <p style="text-align: center;">Agradeçemos por sua compra!</p>

</body>

</html>
