<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatcherJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Controller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
