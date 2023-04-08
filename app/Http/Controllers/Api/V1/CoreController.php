<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoreCompactResponse;
use App\Http\Resources\CoreCompactResource;
use App\Models\Core;
use Illuminate\Http\Request;

class CoreController extends Controller
{

    public function __invoke(): CoreCompactResource
    {
        $core = Core::first();

        return CoreCompactResource::make($core);
    }
}
