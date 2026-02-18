<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseFormRequest;

class UpdateCompanyRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'status'    => 'sometimes|required|string|max:50',
            'is_removed'=> 'nullable|boolean',
        ];
    }
}