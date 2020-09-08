<?php

namespace App\Http\Controllers;

use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\DeleteProjectAction;
use App\Actions\Project\PrepareProjectPayload;
use App\Actions\Project\UpdateProjectAction;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ApiResponse;
use DB;
use Image;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        $project = CreateProjectAction::execute(
            PrepareProjectPayload::execute($request->validated())
        );
        return $project
            ? ApiResponse::success($project)
            : ApiResponse::serverError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $updateProject = UpdateProjectAction::execute(
            Project::find($id),
            PrepareProjectPayload::execute($request->validated())
        );
        return $updateProject
            ? ApiResponse::success($updateProject)
            : ApiResponse::serverError();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProjectRequest $request
     * @param int $id
     *
     * @return Project
     */
    public function destroy(DeleteProjectRequest $request,$id)
    {
        return DeleteProjectAction::execute(Project::find($id));
    }
}
