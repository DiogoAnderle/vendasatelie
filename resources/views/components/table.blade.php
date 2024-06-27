@props(['thead' => ''])
<div class="d-flex justify-content-between mb-3">
    <div>
        <span>Mostrar </span>
        <select id="registries" wire:model.live='quantity'>
            <option value="15">10</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span> Registros</span>
    </div>
    <div class="d-flex align-items-center justify-content-between">

        <div wire:loading wire:target='search' class="spinner-grow text-primary mr-3" role="status">
            <span class="sr-only">Loading...</span>
        </div>

        <input class="form-control" wire:model.live="search" type="text" id="searchTable" placeholder="Pesquisar...">
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped text-center">
        <thead>
            <tr>{{ $thead }}</tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
