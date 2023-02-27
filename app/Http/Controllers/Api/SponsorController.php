<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SponsorResource;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        return SponsorResource::collection(Sponsor::all());
    }
}
