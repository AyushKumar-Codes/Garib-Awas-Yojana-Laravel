<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Role column already exists in the users table
        // This migration is now a no-op
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No operation needed
    }
};
