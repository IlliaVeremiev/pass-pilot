<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            Schema::create('plans', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('organization_id');
                $table->string('name')->nullable(false);
                $table->string('description')->nullable();
                $table->decimal('price', 19, 2)->nullable(false);
                $table->integer('duration')->nullable(false);
                $table->boolean('active')->nullable(false)->default(false);
                $table->timestampsTz();

                $table->foreign('organization_id')
                    ->references('id')
                    ->on('organizations')
                    ->onDelete('cascade');
            });
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
