<?php

namespace Database\Seeders;

use App\Models\Label;
use App\Models\Project;
use App\Models\ProjectLabel;
use App\Models\UsersConnectionProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    User::factory(10)->create();
    Project::factory(100)->create();
    Label::factory(150)->create();
    ProjectLabel::factory(150)->create();
    UsersConnectionProject::factory(20)->create();
  }
}
