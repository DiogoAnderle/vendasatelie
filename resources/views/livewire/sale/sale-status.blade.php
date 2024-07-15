<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-toggle-on"></i></i> Status do Pedido </h3>
    
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <label for="additionOrDiscount"></label>
                <div class="input-group ">
                    {{-- Input checkbox status --}}
                    <div class="form-group form-check col-12 col-md-6">
                        <div class="icheck-primary">
                            <input wire:model.lazy='status' type="checkbox" class="form-control" id="status">
                            <label for="status">Finalizado</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        
    </div>
</div>
