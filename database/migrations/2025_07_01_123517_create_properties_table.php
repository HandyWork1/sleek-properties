<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->tinyInteger('bedrooms')->unsigned();
            $table->tinyInteger('bathrooms')->unsigned();
            $table->decimal('size', 10, 2);
            $table->decimal('price', 15, 2);
            $table->enum('status', ['for_sale', 'for_rent', 'sold', 'rented']);

            $table->foreignId('property_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_condition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('furnishing_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('landlord_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
