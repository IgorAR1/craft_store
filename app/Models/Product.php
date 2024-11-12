<?php

namespace App\Models;

use App\Contracts\HasImage;
use App\Traits\Filterable;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model implements  HasImage
{
    use HasFactory,HasUuids,Filterable,Sortable,Searchable;

    protected $guarded = [];

    public array $searchableProperty = ['title','description'];
    // public function cart(){
    //     return $this->belongsToMany(Cart::class)->withPivot('quantity');
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

//    public function scopeSearch(Builder $builder,string $query = ''): Builder{
//        return $builder->where('title','LIKE',$query.'%')
//            ->orWhere('description', $query.'%');
//    }
    public function image(): MorphMany
    {
        return $this->morphMany(File::class,'model');
    }
}
