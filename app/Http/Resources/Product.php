<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'created_at' => format_date($this->created_at),

            'links' => [
                'create' => $this->when(true, route('products.edit', $this->id)),
                'edit' => $this->when(true, route('products.edit', $this->id)),
                'show' => $this->when(true, route('products.show', $this->id)),
                'destroy' => $this->when(true, route('products.destroy', $this->id)),
            ],
        ];
    }
}
