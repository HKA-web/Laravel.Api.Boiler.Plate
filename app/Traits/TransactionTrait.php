<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Http\JsonResponse;

trait TransactionTrait
{
    public function executeTransaction(callable $callback, string $successMessage = 'Operation successful'): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($callback) {
                return $callback();
            });

            return response()->json([
                'message' => $successMessage,
                'data'    => $result,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error'   => config('app.debug') ? $e->getTrace() : null,
            ], 500);
        }
    }
}
