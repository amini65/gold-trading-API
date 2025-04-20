<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{

    public function getAllUserOrder(Request $request);

}
