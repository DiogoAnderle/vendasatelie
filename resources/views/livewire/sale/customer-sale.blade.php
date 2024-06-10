<div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user"></i>
                Cliente: <span class="badge badge-secondary">{{ $customerName }}</span>
            </h3>
            <div class="card-tools">
                <button wire:click="openModal" class="btn bg-purple btn-sm">Criar cliente</button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Selecionar cliente:</label>

                <!--input group -->
                <div class="input-group" wire:ignore>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>

                    <select wire:model.live="customer" id="select2" class="form-control">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach

                    </select>

                </div>
                <!-- /.input group -->
            </div>
        </div>
        <!-- Modal Cliente -->
        @include('livewire.customer.modal')
        {{-- End Modal --}}
    </div>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection

    @section('scripts')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $('#select2').select2({
                theme: "bootstrap4"
            });
            $('#select2').on('change', function() {
                Livewire.dispatch('customerId', {
                    id: $(this).val()
                })
            })
        </script>
    @endsection

</div>
