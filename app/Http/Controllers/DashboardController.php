<?php

namespace App\Http\Controllers;

use App\Models\Exception;

class DashboardController extends Controller
{
    public function index()
    {

        $exceptions = Exception::query()
            ->with('project:id,title')
            ->latest('created_at')
            ->limit(8)
            ->get([
                'id',
                'status',
                'class',
                'fullUrl',
                'method',
                'file',
                'file_type',
                'line',
                'project_id',
                'exception',
                'created_at',
            ]);

        return inertia('Dashboard', [
            'exceptions'      => $exceptions,
        ]);
    }
}
