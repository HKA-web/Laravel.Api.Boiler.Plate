<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\ExpandableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    use ExpandableResource;

    public function toArray($request)
    {
        return [
            'company_id' => $this->company_id,
            'status'      => $this->status,
            'is_removed'  => $this->is_removed,
        ];
    }
}