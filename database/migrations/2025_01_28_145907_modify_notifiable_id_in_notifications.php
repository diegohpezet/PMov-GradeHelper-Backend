<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNotifiableIdInNotifications extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Cambia el tipo de columna notifiable_id a UUID
            $table->uuid('notifiable_id')->change();
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Revertir el cambio a unsignedBigInteger si fuera necesario
            $table->unsignedBigInteger('notifiable_id')->change();
        });
    }
}
