<?php

namespace App\Http\Controllers;

use App\Models\UsersConnectionProject;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    dump('/project/ index');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \App\Http\Requests\ProjectRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(ProjectRequest $request)
  {
    $userId = (int)$request->get('user_id');
    $name = (string)$request->get('name');
    if (!empty($userId) && !empty($name)) {

      $user = User::where('id', '=', $userId)->first();
      if (!$user) {
        return "Такого пользователя не существует";
      }

      $issetProject = Project::where('name', '=', $name)->first();
      if ($issetProject) {
        return 'Такой проект уже есть, выберите другое имя.';
      }

      $project = new Project();
      $project->name = $name;
      $project->user_id = $user->id;
      $project->save();
      return $project;
    } else {
      return 'Отправляйте правильные данные.';
    }
  }


  /**
   * Display the specified resource.
   *
   * @param \App\Http\Requests\ProjectRequest $request
   * @return \Illuminate\Http\Response
   */
  public function addUsers(Request $request)
  {
    $projectId = (int)$request->get('project_id');
    $userIds = (array)$request->get('userIds');

    if (empty($projectId) || empty($userIds)) {
      return "Поля не должны быть пустыми.";
    }

    $project = Project::where('id', '=', $projectId)->first();

    if (empty($project)) {
      return 'Такого проэкта не существует.';
    }

    foreach ($userIds as $key => $val) {
      if (!is_numeric($val)) {
        unset($userIds[$key]);
      }
    }

    $users = User::whereIn('id', $userIds)->pluck('id')->toArray();

    if (empty($users)) {
      return "Пользователи не найдены";
    }

    $usersConnectionProject = new UsersConnectionProject();
    $usersConnectionProject->project_id = $project->id;
    $usersConnectionProject->user_ids = implode(',', $users);
    $usersConnectionProject->save();

    return $usersConnectionProject;
  }

  /**
   * Display the specified resource.
   *
   * @param string $searchName
   * @param string $searchValue
   * @return \Illuminate\Http\Response
   */
  public function show(string $searchName, string $searchValue)
  {
    $searchName = htmlspecialchars($searchName);
    $searchValue = htmlspecialchars($searchValue);
    if (!empty($searchName) && !empty($searchValue)) {

      if ($searchName === "user.email") {
        return Project::select('projects.id', 'projects.name', 'projects.user_id', 'projects.created_at', 'projects.updated_at')
          ->join('users', 'projects.user_id', '=', 'users.id')
          ->where('users.email', '=', $searchValue)
          ->get();
      } elseif ($searchName === "user.continent") {
        return Project::select('projects.id', 'projects.name', 'projects.user_id', 'projects.created_at', 'projects.updated_at')
          ->join('users', 'projects.user_id', '=', 'users.id')
          ->join('countries', 'users.country_id', '=', 'countries.id')
          ->where('countries.name', '=', $searchValue)
          ->get();
      } elseif ($searchName === "label.mame") { // 'users', 'author_id', '=', 'users.id'
        return Project::select('projects.id', 'projects.name', 'projects.user_id', 'projects.created_at', 'projects.updated_at')
          ->join('project_labels', 'projects.id', '=', 'project_labels.project_id')
          ->join('labels', 'labels.id', '=', 'project_labels.label_id')
          ->where('labels.name', 'like', '%' . $searchValue . '%')
          ->get();
      } elseif ($searchName === "project.name") {
        return Project::where('name', 'like', '%' . $searchValue . '%')->get();
      } else {
        return "Выберите правильный searchName";
      }
    } else {
      return "Поля должны быть заполнены";
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    dump('/project/edit/{id}');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(ProjectRequest $request, $id)
  {
    dump('/project/update/{id}');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
