<?php

namespace App\Http\Controllers;

use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('app.submission.index', [
            'submissions' => Submission::orderBy('id', 'desc')->take(1000)
        ]);
    }
}
