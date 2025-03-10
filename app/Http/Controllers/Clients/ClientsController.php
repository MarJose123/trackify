<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ClientsController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('clients/List', []);
    }
}
