<?php

declare(strict_types=1);

namespace Lightit\System\Flight\Domain\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\System\Flight\Domain\Models\Flight;
use Spatie\QueryBuilder\QueryBuilder;

class ListFlightAction
{
    /**
     * @return LengthAwarePaginator<Flight>
     */
    public function execute(): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<Flight> */
        return QueryBuilder::for(Flight::class)
            ->allowedFilters(['airline_id', 'origin_city_id', 'destination_city_id'])
            ->allowedSorts('departure_datetime', 'arrival_datetime')
            ->paginate();
    }
}
