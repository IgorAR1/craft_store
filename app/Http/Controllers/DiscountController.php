<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Http\Requests\CreateDiscountRequest;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
    public function index()
    {
        return DiscountResource::collection(Discount::paginate(15));
    }

    public function store(CreateDiscountRequest $request)
    {
        $discount = Discount::create($request->validated());
        return new DiscountResource($discount);
    }

    public function show(Discount $discount)
    {
        return new DiscountResource($discount);
    }

    public function update(CreateDiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());
        return new DiscountResource($discount);
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(['message' => 'Discount deleted!']);
    }
}
