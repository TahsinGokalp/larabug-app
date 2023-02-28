<?php

namespace App\Http\Controllers;

use App\Models\Exception;

class PageController extends Controller
{
    public function explanation()
    {
        return view('explanation');
    }

    public function exception(Exception $exception)
    {
        $exception->loadCount('occurences');

        return view('frontend.exception', compact('exception'));
    }
}
