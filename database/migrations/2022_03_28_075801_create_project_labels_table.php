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
    if (!Schema::hasTable('project_labels')) {
      Schema::create('project_labels', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('project_id');
        $table->bigInteger('label_id');
        $table->timestamps();
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
    if (Schema::hasTable('project_labels')) {
      Schema::dropIfExists('project_labels');
    }
  }
};
