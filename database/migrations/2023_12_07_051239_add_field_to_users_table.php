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
            $table->string('roles')->after('email')->default('user');
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('username')->after('name')->nullable();
            $table->string('avatar')->after('id')->nullable();
            $table->string('status')->after('password')->default('active');
            $table->date('birthdate')->nullable();
            $table->timestamp('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('username');
            $table->dropColumn('avatar');
            $table->dropColumn('status');
            $table->dropColumn('birthdate');
            $table->dropColumn('last_login');
        });
    }
};
