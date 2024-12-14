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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('token', 100);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar', 1000);
            $table->integer('type');
            $table->string('open_id', 80);
            $table->string('access_token', 80)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('remember_token', 100)->collate('utf8mb4_unicode_ci')->nullable(); // Explicitly setting collation and making it nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
