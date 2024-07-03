@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-primary">
                <div class="card-header ">
                    <h1><i class="fas fa-exclamation-triangle"></i> {{ __('Offline') }}</h1>
                </div>

                <div class="card-body">
                    <p> Opps algo deu errado</p>
                    <p>
                        <a href="" onclick="window.location.reload(true)">Clique aqui</a> atualizar essa pagina.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection