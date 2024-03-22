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
        Schema::create('admin__profiles', function (Blueprint $table) {
            $table->id();
           // $table->string('company_name')->nullable();
            $table->string('location')->nullable();
            $table->string('created_date')->nullable();
            $table->string('link')->nullable();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin__profiles');
    }
};
