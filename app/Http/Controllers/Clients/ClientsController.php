<?php

namespace App\Http\Controllers\Clients;

use App\Enums\BillingMethod;
use App\Enums\CurrencyCode;
use App\Enums\DefaultWindowSize;
use App\Enums\Status;
use App\Enums\WindowName;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Native\Laravel\Facades\Window;

class ClientsController extends Controller
{
    public function list(Request $request): Response|JsonResponse
    {
        $perPage = $request->query('per_page', 5);
        $clients = Clients::query()
            ->filterByQueryString()
            ->searchByQueryString()
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: $perPage)->appends(request()->query());

        if ($request->wantsJson()) {
            return response()->json($clients);
        }

        if (! app()->runningInConsole() && ! app()->runningUnitTests()) {
            Window::resize(DefaultWindowSize::WIDTH->getSize() + 300, DefaultWindowSize::HEIGHT->getSize(), WindowName::MAIN->getId());
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Client Created',
                'description' => sprintf('Client %s has been saved.', $request->name),
            ], \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
        }

        $request->session()->flash('notification', [
            'success' => [
                'title' => 'Client Created',
                'description' => sprintf('Client %s has been created successfully.', $request->name),
            ],
        ]);

        return $this->list(new Request);
    }

    public function show(Clients $client)
    {
        return Inertia::render('clients/Show', [
            'client' => $client,
        ]);
    }

    public function edit(Clients $client)
    {
        return Inertia::render('clients/Edit', [
            'client' => $client,
            'fields' => [
                'status' => Status::cases(),
                'currency' => CurrencyCode::cases(),
                'billing_method' => BillingMethod::cases(),
            ],
        ]);

    }

    public function update(ClientRequest $request, Clients $client)
    {
        $client->update($request->validated());

        $request->session()->flash('notification', [
            'success' => [
                'title' => 'Client Updated',
                'description' => sprintf('Client %s has been updated successfully.', $client->company_name),
            ],
        ]);

        return Inertia::render('clients/Show', [
            'client' => $client,
        ]);
    }

    public function destroy(Request $request, Clients $client)
    {
        $clientName = $client->name;
        $client->delete();

        $request->session()->flash('notification', [
            'success' => [
                'title' => 'Client Deleted',
                'description' => sprintf('Client %s has been deleted successfully.', $clientName),
            ],
        ]);

        return $this->list(new Request);
    }

    public function tableFilterStatus()
    {
        return response()->json([
            'status' => Status::cases(),
            'currency' => CurrencyCode::cases(),
        ]);

    }
}
