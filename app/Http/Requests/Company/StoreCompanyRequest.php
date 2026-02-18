<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseFormRequest;

class StoreCompanyRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'company_id' => 'required|string|max:255',
            'status'      => 'nullable|string|max:50',
            'is_removed'  => 'nullable|boolean',
        ];
    }
}