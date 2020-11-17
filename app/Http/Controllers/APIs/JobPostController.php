<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{

    /**
     * @return string
     */
    public function index()
    {
        return JobPost::all()->toJson();
    }
}
