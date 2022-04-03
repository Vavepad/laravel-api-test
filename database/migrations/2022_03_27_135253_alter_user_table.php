<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (Schema::hasTable('users')) {
      Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'country_id')) {
          $table->bigInteger('country_id');
        }
      });
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if (Schema::hasTable('users')) {
      Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'country_id')) {
          $table->dropColumn('country_id');
        }
      });
    }
  }
};
