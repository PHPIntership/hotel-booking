<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {

         Schema::table('users', function (Blueprint $table) {
         $table->softDeletes()->after('remember_token');
         });
         Schema::table('admin_hotels', function (Blueprint $table) {
         $table->softDeletes()->after('remember_token');
         });
         Schema::table('admin_users', function (Blueprint $table) {
         $table->softDeletes()->after('remember_token');
         });
         Schema::table('hotels', function (Blueprint $table) {
         $table->softDeletes()->after('description');
         });
     }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('users', function (Blueprint $table) {
       $table->dropColumn('deleted_at');
       });
       Schema::table('admin_hotels', function (Blueprint $table) {
       $table->dropColumn('deleted_at');
       });
       Schema::table('admin_users', function (Blueprint $table) {
       $table->dropColumn('deleted_at');
       });
       Schema::table('hotels', function (Blueprint $table) {
       $table->dropColumn('deleted_at');
       });
    }
}
