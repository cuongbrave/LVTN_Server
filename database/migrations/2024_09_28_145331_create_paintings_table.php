<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('paintings', function (Blueprint $table) {
        //     $table->id();

        //     $table->foreignId('painter_id')->constrained('painters', 'id')->onDelete('cascade');
        //     $table->string('title', 200);
        //     $table->text('body')->nullable();
        //     $table->integer('order')->nullable();


        //     $table->timestamps();
        // });

        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('painter_id')->constrained('painters', 'id')->onDelete('cascade');
            $table->string('title', 200);
            $table->integer('order')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();

            $table->unique(['painter_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paintings');
    }
};
