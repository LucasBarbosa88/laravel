@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Editar produto">
    <breadcrumb-item href="{{ route('home') }}">
        @lang('headings._home')
    </breadcrumb-item>

    <breadcrumb-item active>
        @lang('headings.products.edit')
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="card">
    <div class="card-header">@lang('headings.products.edit')</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}">
            @method('PUT')
            @include('products.partials._form')
            <button class="btn btn-primary" type="submit">@lang('labels.buttons.common.edit')</button>
        </form>
    </div>
</div>
@endsection
