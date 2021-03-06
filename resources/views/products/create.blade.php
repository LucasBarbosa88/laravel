@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Criar produto">
    <breadcrumb-item href="{{ route('home') }}">
        @lang('headings._home')
    </breadcrumb-item>

    <breadcrumb-item active>
        @lang('headings.products.create')
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="card">
    <div class="card-header">@lang('headings.products.create')</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('products.store') }}">
            @include('products.partials._form')
            <button class="btn btn-primary" type="submit">@lang('links._create')</button>
        </form>
    </div>
</div>
@endsection
