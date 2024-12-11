<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\City\Domain\Models\City;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(Airline::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(City::class, 'origin_city_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(City::class, 'destination_city_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamp('departure_datetime');
            $table->timestamp('arrival_datetime');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
