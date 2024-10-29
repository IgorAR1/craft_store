<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidFilterName;
use Illuminate\Foundation\Http\FormRequest;

class QueryRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'sort' => ['nullable', 'string'],
            'filter' => ['nullable', 'string'],
        ];
    }
    public function getFilterQueryProperty()
    {
        return collect($this->input('filter'))->keys();

    }
    public function getFilterValues(string $property): array|string
    {
        return collect($this->input('filter'))->get($property);
    }

    public function getSortProperty()
    {
        return collect($this->input('sort'));
    }
    public function getSortDirection()
    {
        $direction = $this->input('direction');

        if (!$direction){
            $direction = 'asc';
        }

        return $direction;
    }

    public function getSearchQuery()
    {
        return collect($this->input('search'));
    }

}
