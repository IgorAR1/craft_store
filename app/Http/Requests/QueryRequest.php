<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidFilter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class QueryRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'search' => ['string'],
            'sort' => ['nullable', 'string'],

            'filter' => 'array',
            'filter.*' => ['string'],
//            'filter.*.*' => ['string'],
        ];
    }
    public function getFilterQueryProperties(): Collection
    {
//        return collect($this->input('filter'))->keys();
        return collect($this->input('filter'))->keys();

    }
    public function getFilterValues(string $property): string
    {
        return collect($this->input('filter'))->get($property);
    }

    public function getSortProperties(): Collection
    {
        return collect($this->input('sort'));
    }
    public function getSortDirection(): string
    {
        return $this->input('direction') ?: 'asc';
    }

    public function getSearchQuery(): string
    {
        return $this->input('search') ?: '';
    }

}
