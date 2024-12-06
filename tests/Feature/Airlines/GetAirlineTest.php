<?php

declare(strict_types=1);

namespace Tests\Feature\Airlines;

use Database\Factories\AirlineFactory;
use function Pest\Laravel\getJson;

describe('airlines', function () {
    it('can get an airline successfully', function () {
        $airline = AirlineFactory::new()->createOne();

        getJson(url("/api/airlines/{$airline->id}"))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $airline->id,
                    'name' => $airline->name,
                ],
            ]);
    });

    it('returns 404 if the airline does not exist', function () {
        getJson(url('/api/airlines/999'))
            ->assertNotFound();
    });
});
