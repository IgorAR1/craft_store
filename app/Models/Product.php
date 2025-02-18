<?php

namespace App\Models;

use App\Contracts\DiscountableContract;
use App\Contracts\HasImage;
use App\Observers\ProductObserver;
use App\Traits\Filterable;
use App\Traits\HasDiscounts;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model implements HasImage,DiscountableContract
{
    use HasFactory,HasUuids,Filterable,Sortable,Searchable,HasDiscounts;

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

    public function getDiscounts(): Collection
    {
        return Discount::query()->where('subject','product')->orderBy('discount_amount')->get();
    }

    public function getTotalPrice(): float
    {
        return $this->price;
    }
}
