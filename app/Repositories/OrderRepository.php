<?php
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Repository;

class OrderRepository extends Repository
{
    protected function getClass()
    {
        return Order::class;
    }
}
