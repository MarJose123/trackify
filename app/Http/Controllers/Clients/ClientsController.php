<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClientsController extends Controller
{
    public function create(Request $request): Response
    {
        $clients = Clients::paginate(200);

        return Inertia::render('clients/List', [
            'clients' => $clients,
        ]);
    }
}
