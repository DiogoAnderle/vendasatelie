<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fatura de Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

        /* Tachyons extensions */

        .npurple-1 {
            color: #820AD1;
        }

        .n-grey-777 {
            color: #777777
        }

        #qr-data {
            color: black;
            background-color: white;
        }

        #qr-container {
            width: 12em;
            height: 12em;
            mix-blend-mode: normal;
            border-color: #820AD1;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td width="25%">
                <img src="{{ public_path() . '/' . 'storage/' . $shop->image->url }}" alt="" srcset=""  width="150px">
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
                    Recibo: <span class="fatura-id">RC-{{ $sale->id }}</span>
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
            <th>Descrição</th>
            <th>Valor</th>
            <th>Quantidade</th>
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
                <td><b>Acréscimo / Desconto:</b></td>
                <td><b>{{ currencyBRLFormat($sale->addition_discount) }}</b></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td><b>Total:</b></td>
                <td><b>{{ currencyBRLFormat($sale->net_value) }}</b></td>
            </tr>

        </tbody>
    </table>

    <table width="100%" style="text-align: center; margin-top:1rem;">
        <tr>
            <td>
                Recebemos o valor de <b>{{ currencyBRLFormat($sale->net_value) }}</b> de <b>{{ $sale->customer->name
                    }}</b>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                Referente aos produto(s) acima destacado(s).
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
                __________________________________________ <br>
                <br>
                <b>{{ $sale->user->name }}</b> <br>
                Vendedor
            </td>
        </tr>
    </table>
    <p style="text-align: center;">Agradeçemos por sua compra!</p>


    <!-- <table width="100%" style="text-align: center; margin: 2rem 3rem;">
        <tr>
            <td width="50%" style="text-align: center; margin-top:5rem;">
                <div class="card" style="width: 15rem;">
                    <div class="cartd-title">
                        <h3>Pix Nubank</h3>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                         <img class="card-img-top" 
                             style="width: 100; border-radius: 15px;" 
                             src="{{ public_path() . '/' . 'storage/shop/qrcode-nubank.png'}}" 
                             alt="qr-code-nubank" />
                    </div>
                     <div>
                         <p class="card-text">Escaneie o QR Code ou clique no botão abaixo para abrir o pagamento detalhado</p>
                     </div>
                     
                     <div class="card-footer">
                          <a href="https://nubank.com.br/cobrar/y3oh0/66999afc-7ef8-444e-8247-7c1d02d9baae" style="width: 50px;" 
                                 class="btn btn-lg" style="background-color: #a249dd; color: white;">
                                 Nubank                                 
                             </a>
                     </div>
                 </div>
            </td>
            <td width="50%" style="text-align: center; margin-top:5rem;">
                <div class="card" style="width: 15rem;">
                    <div class="cartd-title">
                        <h3>Parcelado 3x sem juros</h3>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                         <img class="card-img-top" 
                             style="width: 135; border-radius: 15px;" 
                             src="{{ public_path() . '/' . 'storage/shop/mercadopago.jpg'}}" 
                             alt="logo-mercado-pago" />
                    </div>

                     <div>
                         <p class="card-text">Clique no botão abaixo e solicite o link para pagamento em até 3x sem juros</p>
                     </div>
                     
                     <div class="card-footer">
                          <a href="https://wa.me/47989090879?text=Olá%204%20de%20Nós%20Ateliê,%20gostaria%20de%20parcelar%20minha%20compra%20no%20valor%20de%20{{ currencyBRLFormat($sale->net_value) }}%20em%203x%20sem%20juros." class="btn btn-primary btn-lg">Mercado Pago</a>
                     </div>
                </div>
            </td>
        </tr>
    </table> -->

</body>

</html>