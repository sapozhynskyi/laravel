<?php

namespace Tests\Feature\Admin;

use App\Helpers\Enums\RolesEnum;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\CategoryProductsSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function afterRefreshingDatabase()
    {
        $this->seed(RolesTableSeeder::class);
        $this->seed(CategoryProductsSeeder::class);

    }
    public function setUp():void {
        parent::setUp();
        $this->user = $this->getUser();
    }
    public function test_all_products_rendered(){
        $response = $this->actingAs($this->user)->get(route('admin.products.index'));
        $products = Product::paginate(5)->pluck('title')->toArray();
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
        $response->assertSeeInOrder($products);
    }
    protected function getUser():User {
        return User::factory()->admin()->create();
    }
}
