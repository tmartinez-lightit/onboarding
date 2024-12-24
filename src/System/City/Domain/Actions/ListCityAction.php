<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\System\City\Domain\Models\City;
use Spatie\QueryBuilder\QueryBuilder;

class ListCityAction
{
    /**
     * @return LengthAwarePaginator<City>
     */
    public function execute(): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<City> */
        return QueryBuilder::for(City::class)
            ->allowedFilters(['name', 'id'])
            ->allowedSorts('name', 'id')
            ->paginate();
    }
}
