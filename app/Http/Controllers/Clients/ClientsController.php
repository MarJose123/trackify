<?php

namespace App\Http\Controllers\Clients;

use App\Enums\BillingMethod;
use App\Enums\CurrencyCode;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClientsController extends Controller
{
    public function list(Request $request): Response|JsonResponse
    {
        $perPage = $request->query('per_page', 5);
        $clients = Clients::query()
            ->filterByQueryString()
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: $perPage)->appends(request()->query());

        if($request->wantsJson()) {
            return response()->json($clients);
        }

        return Inertia::render('clients/List', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return Inertia::render('clients/Create', [
            'fields' => [
                'status' => Status::cases(),
                'currency' => CurrencyCode::cases(),
                'billing_method' => BillingMethod::cases(),
            ],
        ]);
    }

    public function store(ClientRequest $request)
    {
        Clients::create([
            'user_id' => $request->user()->id,
            ...$request->validated(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Client created',
            'description' => sprintf('Company Name %s has been saved.', $request->company_name),
        ], \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    }

    public function tableFilterStatus()
    {
        return response()->json([
            'status' => Status::cases(),
            'currency' => CurrencyCode::cases(),
        ]);

    }
}
