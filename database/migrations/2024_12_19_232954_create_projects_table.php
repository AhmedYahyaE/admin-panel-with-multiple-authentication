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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();



            $table->string('name');
            $table->text('description');
        });



        // Create the pivot table between `projects` and `users`
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();



            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null')->default(1);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
