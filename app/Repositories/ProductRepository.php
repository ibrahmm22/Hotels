<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;

class ProductRepository extends Repository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProductIngredients($product)
    {
        return $product->ingredients;
    }
}
