<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->date('verjaardag')->nullable()->after('username');
            $table->text('about_me')->nullable()->after('verjaardag');
            $table->string('profile_picture')->nullable()->after('about_me');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'verjaardag', 'about_me', 'profile_picture']);
        });
    }
}