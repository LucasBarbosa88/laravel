<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Repository;

class ProductRepository extends Repository
{
    protected function getClass()
    {
        return Product::class;
    }
}
