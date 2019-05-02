<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;

use App\Http\Requests\OrderRequest;

use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store()
    {
        
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function getPagination($pagination)
    {
        return $pagination->repository(OrderRepository::class)
            ->resource(OrderResource::class);
    }
}