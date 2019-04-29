<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    private $product;

    /** @test */
    public function shouldntCreateWhenMissingData()
    {
        $new_product_form_data = factory(Product::class)->make()->toArray();
        $new_product_form_data['description'] = '';
        $new_product_form_data['name'] = '';
        $new_product_form_data['price'] = '';
        $new_product_form_data['sku'] = csrf_token();

        $this->call('POST', route('products.store'), $new_product_form_data)
             ->assertSessionHasErrors('description')
             ->assertSessionHasErrors('name')
             ->assertSessionHasErrors('price');
    }

    /** @test */
    public function shouldCreateWhenCorrectData()
    {
        $new_user_form_data = factory(Product::class)->make()->toArray();
        $new_user_form_data['password'] = 'secret';
        $new_user_form_data['password_confirmation'] = 'secret';
        $new_user_form_data['_token'] = csrf_token();

        $this->call('POST', route('users.store'), $new_user_form_data)
             ->assertRedirect()
             ->assertSessionHas('success');
    }

    /** @test */
    public function shouldntUpdateWhenIncorrectData()
    {
        $user = User::first();
        $user_invalid = factory(User::class)->states('invalid')->make()->toArray();
        $user_invalid['id'] = $user->id;
        $user_invalid['_token'] = csrf_token();

        $this->call('PUT', route('users.update', $user_invalid['id']), $user_invalid)
             ->assertRedirect()
             ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function shouldUpdateWhenCorrectData()
    {
        $product = User::first()->toArray();
        $product['name'] = 'NEW NAME';
        $product['description'] = 'Description';
        $product['price'] = 11.0;
        $product['sku'] = csrf_token();

        $this->call('PUT', route('products.update', $product['id']), $product)
             ->assertRedirect()
             ->assertSessionHas('success');
    }
}
