<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Produtos Mais Vendidos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório de Produtos Mais Vendidos</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Preço Venda</th>
                <th>Quantidade Vendida</th>
                <th>Total Vendido</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bestSellingProducts as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ currencyBRLFormat($product->price) }}</td>
                    <td>{{ $product->total_quantity }}</td>
                    <td>{{ currencyBRLFormat($product->price * $product->total_quantity) }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Nenhum produto encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>