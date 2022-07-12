<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\FetchSentiments;
use Google\Cloud\Language\LanguageClient;

class SentimentController extends Controller
{
    public function index()
    {
        echo "running jobs";
        $language = new LanguageClient();
        $annotation = $language->analyzeSentiment("Hello world");
        $sentiment = $annotation->sentiment();
        echo $sentiment['score'];
        echo $sentiment['magnitude'];
        //FetchSentiments::dispatchSync();
    }
}
