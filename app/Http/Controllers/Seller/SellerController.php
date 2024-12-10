<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{

    public function index()
    {
        $vendedores = Seller::has('products')->get();

        return $this->showAll($vendedores);

    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller , 200);
    }

}
