<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch;

class CreateIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search_index:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the index in elastic search if it does not exist';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Elasticsearch::indices()->create(['index' => env('ELASTICSEARCH_INDEX')]);
        Elasticsearch::indices()->putMapping([
            'index' => env('ELASTICSEARCH_INDEX'),
            'body' => [
                "properties" => [
                    "create_date" => [
                        "type" => "date",
                        "format" => "yyyy-MM-dd"
                    ]
                ]
            ]
        ]);
    }
}
