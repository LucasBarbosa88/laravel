@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="card">
        <div class="card-header" style="text-align:right" >
            <a class="navbar-brand" href="{{ url('/products') }}">
                <h5>Voltar</h5>
            </a>
        </div>
        <div class="card-header">Informações do pedido</div>
            <div class="card-body">
                <h2 style="text-align:center;"> Cliente: {{$order->client_name}} </h2> <br>
                <p style="text-align:center;"> Valor total:  {{$order->total_price}} R$</p> <br>
                <p style="text-align:center;"> Data:  {{$order->created_at}}</p>
                <p style="text-align:center;"> Produtos:  {{$order->products_list}}</p>

            </div>
        </div>
    </div>
</div>
@endsection
