<?php

namespace App\Actions\Project;


use App\Models\Project;
use Illuminate\Support\Facades\Log;

class DeleteProjectAction
{
    /**
     * Update an existing project.
     *
     * @param Project $project
     *
     * @return Project
     */
    public static function execute(Project $project): ?Project
    {
        try {
            if (!$project->delete()) {
                throw new \Exception("Could not delete project.");
            }
            return $project;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
