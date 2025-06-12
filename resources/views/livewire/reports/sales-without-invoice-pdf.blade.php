<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas Sem Nota</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>{{ $shop->name ?? 'Relatório' }}</h2>
    <p><strong>Relatório de Vendas Sem Nota</strong></p>
    <p>Período: {{ $startDate ?? '...' }} a {{ $endDate ?? '...' }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Total</th>
                <th>Desconto</th>
                <th>Valor Líquido</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesWithoutInvoice as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($sale->addition_discount, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($sale->net_value, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($sale->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="margin-top: 20px;">Total Geral (sem nota): R$ {{ number_format($totalSalesWithoutInvoice, 2, ',', '.') }}</h4>
</body>
</html>
