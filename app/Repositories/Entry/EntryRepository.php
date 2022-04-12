<?php

namespace App\Repositories\Entry;

use Illuminate\Http\Request;
use App\Models\Entry;
use Elasticsearch;
use Illuminate\Database\Eloquent\Collection;

class EntryRepository implements EntryInterface
{
    private $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function create($entry): bool
    {
        $save = $this->entry->create($entry);
        if ($save) {
            $data = [
                'body' => ['id' => $save->id, 'entry' => $save->entry],
                'index' => env("ELASTICSEARCH_INDEX"),
                'type' => '_doc',
                'id' => $save->id
            ];
            Elasticsearch::index($data);
            return true;
        }
        return false;
    }

    public function list(): Collection
    {
        return $this->entry->all();
    }

    public function search($keyword): array
    {
        $entry = [];
        $params = [
            'index' => env("ELASTICSEARCH_INDEX"),
            'body'  => [
                'query' => [
                    'prefix' => [
                        'entry' => $keyword
                    ]
                ]
            ]
        ];
        $results = Elasticsearch::search($params);
        if ($results) {
            foreach ($results['hits']['hits'] as $result) {
                $entry[] = $result['_source'];
            }
        }
        return $entry;
    }
}
