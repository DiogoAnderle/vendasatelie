<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-toggle-on"></i></i> Status do Pedido </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="input-group col-12">
                    {{-- Input checkbox status --}}
                    <div class="form-group form-check col-12 col-md-6">
                        <div class="icheck-primary">
                            <input wire:model.lazy='status' type="checkbox" {{ $status == 0 ? 'unchecked' : 'checked' }}
                                class="form-control" id="status">
                            <label for="status">Finalizado</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group col-12">
                    {{-- Input checkbox status --}}
                    <div class="form-group form-check col-12 col-md-6">
                        <div class="icheck-primary">
                            <input wire:model.lazy='invoice' type="checkbox"
                                {{ $invoice == 0 ? 'unchecked' : 'checked' }} class="form-control" id="invoice">
                            <label for="invoice">Nota Fiscal</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
