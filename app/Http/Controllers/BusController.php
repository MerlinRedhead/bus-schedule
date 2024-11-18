<?php

namespace App\Http\Controllers;

use App\Services\BusService;
use Illuminate\Http\Request;

class BusController extends Controller
{
    protected $busService;

    public function __construct(BusService $busService)
    {
        $this->busService = $busService;
    }

    public function findBus(Request $request)
    {
        $request->validate([
            'from' => 'required|exists:stops,id',
            'to' => 'required|exists:stops,id',
        ]);

        $result = $this->busService->findBuses($request->from, $request->to);

        return response()->json($result);
    }

}
