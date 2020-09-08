<?php

namespace App\Actions\Project;


use App\Models\Project;
use Illuminate\Support\Facades\Log;

class UpdateProjectAction
{
    /**
     * Update an existing project.
     *
     * @param Project $project
     * @param array $data
     *
     * @return Project
     */
    public static function execute(Project $project, array $data): ?Project
    {
        try {
            if (!$project->update($data)) {
                throw new \Exception("Could not update project.");
            }
            return $project;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
