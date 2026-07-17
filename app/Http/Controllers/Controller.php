<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Landing API"
)]
#[OA\Server(
    url: "http://localhost:8080/api"
)]
abstract class Controller
{
}