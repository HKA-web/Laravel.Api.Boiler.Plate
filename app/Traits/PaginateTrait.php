<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait PaginateTrait
{
    public function paginateQuery($query, Request $request, int $maxTake = 100)
    {
        $startTime = microtime(true);

        $skip = max((int) $request->query('skip', 0), 0);
        $take = min((int) $request->query('take', 10), $maxTake);

        $baseQuery = clone $query;

        $query = $baseQuery
            ->select('*')
            ->selectRaw('COUNT(*) OVER() AS full_count')
            ->skip($skip)
            ->take($take);

        $rows = $query->get();

        $total = $rows->isNotEmpty() ? (int) $rows[0]->full_count : 0;

        $data = $rows->map(function ($row) {
            unset($row->full_count);
            return $row;
        });

        return [
            'skip'       => $skip,
            'take'       => $take,
            'totalCount' => $total,
            'execution'  => round((microtime(true) - $startTime) * 1000, 2),
            'data'       => $data,
        ];
    }
}
