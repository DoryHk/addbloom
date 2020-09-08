<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Log;

class CreateProjectAction
{
    /**
     * Create a new project and persist it to the DB.
     *
     * @param array $data
     *
     * @return Project
     */
    public static function execute(array $data): ?Project
    {
        try {
            return Project::create($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
