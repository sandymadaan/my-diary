<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Entry extends Model
{
    use HasFactory;
    use ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entry'
    ];

    protected $table = 'entries';

    protected $mappingProperties = array(
        'entry' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
      );
}
