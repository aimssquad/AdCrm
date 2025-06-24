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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['organization', 'tl', 'associate'])->default('associate');
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->unsignedBigInteger('tl_id')->nullable()->after('organization_id');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Foreign key constraints
            $table->foreign('organization_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tl_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['tl_id']);
            $table->dropColumn(['role', 'organization_id', 'tl_id', 'phone', 'address']);
        });
    }

};
