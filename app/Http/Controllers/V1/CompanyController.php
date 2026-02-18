<?php

namespace App\Http\Controllers\V1;

use App\Helpers\DebugHelper;
use App\Helpers\ExpandHelper;
use App\Helpers\QueryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use App\Traits\PaginateTrait;
use App\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use PaginateTrait, TransactionTrait;

    public function index(Request $request)
    {
        try {
            $model = new Company();
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
                'data' => CompanyResource::collection($pagination['data']),
            ]));
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => config('app.debug') ? DebugHelper::formatTrace($e) : null,
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $model = new Company();
            $connection = QueryHelper::getConnection($request, $model);

            $expandTree = ExpandHelper::parse($request->query('expand'));
            $with = ExpandHelper::toWith($expandTree);

            $filterExpr = $this->getFilterExpression($request);

            $query = QueryHelper::newQuery($model, $connection)->with($with);
            $query = $this->applyExpressionFilter($query, $filterExpr);
            $query->where('company_id', $id);

            $data = $query->firstOrFail();

            return response()->json([
                'data'       => new CompanyResource($data),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error'      => config('app.debug') ? DebugHelper::formatTrace($e) : null,
            ], 500);
        }
    }

    public function store(StoreCompanyRequest $request)
    {
        return $this->executeTransaction(function () use ($request) {
            $model = new Company();
            $connection = QueryHelper::getConnection($request, $model);
            $data = $request->validated();
            if ($connection) $model->setConnection($connection);
            $model->fill($data);
            $model->save();

            return new CompanyResource($model);
        }, 'Data created successfully');
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        return $this->executeTransaction(function () use ($request, $id) {
            $query = QueryHelper::query(Company::class, $request);
            $item = $query->findOrFail($id);

            $data = $request->validated();
            $item->update($data);

            return new CompanyResource($item);
        }, 'Data updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        return $this->executeTransaction(function () use ($request, $id) {
            $query = QueryHelper::query(Company::class, $request);
            $item = $query->findOrFail($id);
            $item->delete();

            return null;
        }, 'Data deleted successfully');
    }

}
