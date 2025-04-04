<?php

namespace App\Http\Controllers\Clock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClockController extends Controller
{
    public function index()
    {
        return Inertia::render('clock/Index');
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
