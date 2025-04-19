<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->nullable(false);
            $table->foreignUuid('plan_id')->nullable(false);
            $table->foreignUuid('user_id')->nullable(false);
            $table->dateTimeTz('start_at')->nullable(false);
            $table->dateTimeTz('end_at')->nullable(false);
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
