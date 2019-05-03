@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Pedidos">
    <breadcrumb-item href="{{ route('home') }}">
        @lang('headings._home')
    </breadcrumb-item>

    <breadcrumb-item active>
        @lang('headings.orders.index')
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-md-12">
        <data-list data-source="{{ route('pagination.orders') }}"
                   delete-message="Tem certeza que deseja apagar este registro ?"
                   url-create="{{ route('orders.create') }}"
                   label-create="Novo pedido"
                   />
   </div>
</div>
@endsection

@section('custom-template')
<template id="data-list" slot-scope="modelScope">
    <div>
        <div class="row my-2">
            <div class="col-md-6">
                <a v-if="urlCreate" :href="urlCreate">
                    <button class="btn btn-primary">@{{labelCreate}}</button>
                </a>
            </div>
            <div class="col-md-6">
                <input type="text" v-model="query" class="form-control"
                    placeholder="Buscar ..." >
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    @include('orders.partials._head')
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items" :key="index">
                    @include('orders.partials._body')
                    <td>@include('shared.partials._buttons_actions')</td>
                </tr>
            </tbody>
        </table>
        @include('shared.partials._pagination')
    </div>
</template>
@endsection
