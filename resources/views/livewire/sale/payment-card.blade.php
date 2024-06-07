<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-wallet"></i> Pago </h3>

        <div class="card-tools d-flex justify-content-center align-self-center">

            <span class="mr-2">Total: <b>{{ currencyBRLFormat($total) }}</b></span>

            <!-- Incluir boton moneda -->

        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <label for="additionOrDiscount">Acréscimo / Desconto:</label>
                <div class="input-group ">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                    </div>

                    <input type="number" wire:model.live="additionOrDiscount" class="form-control"
                        id="additionOrDiscount" min="" value="0">

                </div>
                @if ($additionOrDiscount > 0)
                    <p>
                        <strong>Total por extenso:</strong>
                        {{ numbersInFull($additionOrDiscount) }}

                    </p>
                @endif
            </div>
            <div class="col-6">
                <label for="netValue">Total:</label>
                <div class="input-group ">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                    </div>
                    <input type="number" wire:model="netValue" id="netValue" class="form-control" readonly>


                </div>

                @if ($netValue > 0)
                    <p>
                        <strong>Total por extenso:</strong>
                        {{ numbersInFull($netValue) }}

                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
