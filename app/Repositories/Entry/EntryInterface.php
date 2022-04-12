<?php

namespace App\Repositories\Entry;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface EntryInterface
{
    public function create($entry): bool;

    public function list(): Collection;

    public function search($data): array;
}
