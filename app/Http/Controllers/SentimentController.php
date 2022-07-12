<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\FetchSentiments;

class SentimentController extends Controller
{
    public function index()
    {
        echo "running jobs";
        FetchSentiments::dispatch();
    }
}
