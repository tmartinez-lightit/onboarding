<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Database\Factories\UserFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Lightit\Backoffice\Users\App\Transformers\UserTransformer;
use Lightit\Backoffice\Users\Domain\Models\User;
use function Pest\Laravel\getJson;

describe('users', function () {
    it('can list users successfully', function () {
        /** @var Collection<int, User> $users */
        $users = UserFactory::new()
            ->count(5)
            ->create();

        $transformer = new UserTransformer();

        getJson(url('/api/users'))
            ->assertSuccessful()
            ->assertExactJson([
                'status' => JsonResponse::HTTP_OK,
                'success' => true,
                'data' => $users->map(fn (User $user) => $transformer->transform($user))->toArray(),
            ]);
    });
});
