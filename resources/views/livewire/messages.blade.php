<div>
    @if (session()->has('msg'))
        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" id="messages" role="alert">
            <strong>Mensagem!</strong> {{ session('msg') }}

            @if (session()->has('sale'))
                <a href="{{ route('sales.invoice', session('sale')) }}" target="_blank">
                    <i class="far fa-file-pdf"></i>
                </a>
            @else
            @endif


            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

</div>
