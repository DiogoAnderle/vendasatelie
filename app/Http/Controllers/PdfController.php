<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function invoicePdf(Sale $sale)
    {
        $shop = Shop::first();
        $pdf = Pdf::loadView('livewire.sale.invoice', compact('sale', 'shop'));
        return $pdf->stream('FV-'.$sale->id.'.pdf');
    }
}
