<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Order extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'client_name' => $this->client_name,
            'total_price' => $this->total_price,
            'products_list' => $this->products_list,

            'links' => [
                'create' => $this->when(true, route('orders.edit', $this->id)),
                'edit' => $this->when(true, route('orders.edit', $this->id)),
                'show' => $this->when(true, route('orders.show', $this->id)),
                'destroy' => $this->when(true, route('orders.destroy', $this->id)),
            ],
        ];
    }
}
