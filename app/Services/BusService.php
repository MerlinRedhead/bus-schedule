<?php
namespace App\Services;

use App\Models\Stop;
use Carbon\Carbon;

class BusService
{
    public function findBuses($fromId, $toId)
    {
        $from = Stop::findOrFail($fromId);
        $to = Stop::findOrFail($toId);

        $routes = $from->routes()->whereHas('stops', function ($query) use ($to) {
            $query->where('stops.id', $to->id);
        })->get();

        $result = [
            'from' => $from->name,
            'to' => $to->name,
            'buses' => [],
        ];

        foreach ($routes as $route) {
            $buses = $route->buses;
            foreach ($buses as $bus) {
                $result['buses'][] = [
                    'route' => "Автобус №{$bus->name} в сторону ост. {$route->stops->last()->name}",
                    'next_arrivals' => $this->getNextArrivals(),
                ];
            }
        }

        return $result;
    }

    private function getNextArrivals()
    {
        // Здесь должна быть реальная логика расчета времени прибытия
        // Для примера используем случайные значения
        $now = Carbon::now();
        $arrivals = [];
        for ($i = 0; $i < 3; $i++) {
            $arrivals[] = $now->addMinutes(rand(15, 60))->format('H:i');
        }
        return $arrivals;
    }
}
