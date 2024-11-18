<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        return Route::with('stops')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stops' => 'required|array|min:2',
            'stops.*' => 'exists:stops,id',
        ]);

        $route = Route::create(['name' => $request->name]);
        $route->stops()->attach($request->stops);

        return response()->json($route->load('stops'), 201);
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'stops' => 'sometimes|array|min:2',
            'stops.*' => 'exists:stops,id',
        ]);

        $route->update($request->only('name'));

        if ($request->has('stops')) {
            $route->stops()->sync($request->stops);
        }

        return response()->json($route->load('stops'));
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return response()->json(null, 204);
    }
}
