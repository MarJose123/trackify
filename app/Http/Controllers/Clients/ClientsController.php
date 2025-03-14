<?php

namespace App\Http\Controllers\Clients;

use App\Enums\BillingMethod;
use App\Enums\CurrencyCode;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClientsController extends Controller
{
    public function list(Request $request): Response
    {
        $clients = Clients::paginate(200);

        return Inertia::render('clients/List', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return Inertia::render('clients/Create',[
            'fields' => [
                'status' => Status::cases(),
                'currency' => CurrencyCode::cases(),
                'billing_method' => BillingMethod::cases(),
            ]
        ]);
    }

    public function tableFilterStatus()
    {
        return response()->json([
            'status' => Status::cases(),
            'currency' => CurrencyCode::cases(),
        ]);

    }
}
