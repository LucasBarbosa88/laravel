@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="card">
        <div class="card-header" style="text-align:right" >
            <a class="navbar-brand" href="{{ url('/products') }}">
                <h5>Voltar</h5>
            </a>
        </div>
        <div class="card-header">Informações do Produto</div>
            <div class="card-body">
                <h2 style="text-align:center;"> {{$product->name}} </h2> <br>
                <p style="text-align:center;"> Valor:  {{$product->price}} R$</p> <br>
                <p style="text-align:center;"> Descrição:  {{$product->description}}</p>
            </div>
        </div>
    </div>
</div>
@endsection
