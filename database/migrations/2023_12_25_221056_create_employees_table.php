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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('full_name')->virtualAs("concat(first_name, ' ', last_name)");
            $table->date('dob');
            $table->string('ssn', 9);
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('work_email')->nullable();
            $table->string('work_phone', 20)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('city', 30)->nullable();
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->string('zip', 20)->nullable();
            $table->string('title', 30)->nullable();
            $table->foreignId('dept_id')->nullable()->constrained('depts');
            $table->foreignId('manager_id')->nullable()->constrained('employees');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
