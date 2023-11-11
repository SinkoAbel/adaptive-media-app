<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Adaptive Media Application Documentation",
 *      description="This is the swagger endpoint documentation of the project for Adaptive Media.",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
