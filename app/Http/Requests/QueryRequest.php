<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidFilterName;
use Illuminate\Foundation\Http\FormRequest;

class QueryRequest extends FormRequest
{

    public function rules(): array
    {
//        dd($this->all());
        return [
            'search' => ['string'],
            'sort' => ['nullable', 'string'],

            'filter' => 'array',
            'filter.*' => ['string'],
//            'filter.*.*' => ['string'],
        ];
    }
    public function getFilterQueryProperties()
    {
//        return collect($this->input('filter'))->keys();
        return collect($this->input('filter'))->keys();

    }
    public function getFilterValues(string $property)
    {
        return collect($this->input('filter'))->get($property);
    }

    public function getSortProperty()
    {
        return collect($this->input('sort'));
    }
    public function getSortDirection()
    {
        return $this->input('direction') ?: 'asc';
    }

    public function getSearchQuery()
    {
        return $this->input('search') ?: '';
    }

}
