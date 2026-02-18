<?php

namespace App\Http\Controllers\V1;

use App\Helpers\DebugHelper;
use App\Helpers\ExpandHelper;
use App\Helpers\QueryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\PaginateTrait;
use App\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use PaginateTrait, TransactionTrait;

    public function index(Request $request)
    {
        try {
            $model = new Product();
            $connection = QueryHelper::getConnection($request, $model);

            $expandTree = ExpandHelper::parse($request->query('expand'));
            $with = ExpandHelper::toWith($expandTree);

            $filterExpr = $this->getFilterExpression($request);

            $baseQuery = QueryHelper::newQuery($model, $connection);
            $baseQuery = $this->applyExpressionFilter($baseQuery, $filterExpr);

            $query = clone $baseQuery;
            $query = $query->with($with);

            $pagination = $this->paginateQuery($query, $request);

            return response()->json(array_merge(
            $pagination, [
                'data' => ProductResource::collection($pagination['data']),
            ]));
        } catch (\Throwable $e) {
            return response()->json([
                'error' => config('app.debug') ? DebugHelper::formatTrace($e) : null,
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $model = new Product();
            $connection = QueryHelper::getConnection($request, $model);

            $expandTree = ExpandHelper::parse($request->query('expand'));
            $with = ExpandHelper::toWith($expandTree);

            $filterExpr = $this->getFilterExpression($request);

            $query = QueryHelper::newQuery($model, $connection)->with($with);
            $query = $this->applyExpressionFilter($query, $filterExpr);
            $query->where('product_id', $id);

            $data = $query->firstOrFail();

            return response()->json([
                'data'  => new ProductResource($data),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => config('app.debug') ? DebugHelper::formatTrace($e) : null,
            ], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        return $this->executeTransaction(function () use ($request) {
            $model = new Product();
            $connection = QueryHelper::getConnection($request, $model);
            $data = $request->validated();
            if ($connection) $model->setConnection($connection);
            $model->fill($data);
            $model->save();

            return new ProductResource($model);
        }, 'Data created successfully');
    }

    public function update(UpdateProductRequest $request, $id)
    {
        return $this->executeTransaction(function () use ($request, $id) {
            $query = QueryHelper::query(Product::class, $request);
            $item = $query->findOrFail($id);

            $data = $request->validated();
            $item->update($data);

            return new ProductResource($item);
        }, 'Data updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        return $this->executeTransaction(function () use ($request, $id) {
            $query = QueryHelper::query(Product::class, $request);
            $item = $query->findOrFail($id);
            $item->delete();

            return null;
        }, 'Data deleted successfully');
    }

}