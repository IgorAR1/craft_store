<?php

namespace App\Services\Discount\Actions;

use App\Contracts\DiscountableContract;
use App\Factories\DiscountActionFactory;
use App\Models\Discount;

class ActionApplicator
{
    public function __construct(readonly DiscountActionFactory $actionFactory)
    {
    }

    public function apply(DiscountableContract $model, Discount $discount): void
    {
        $actions = $discount->getActions();

        array_reduce($actions, function ($result, $action) {
            $action = $this->actionFactory->make($action);
            $action->execute($result);

            return $result;
        }, $model);
//        foreach ($actions as $action) {
//            $action = $this->actionFactory->make($action);
//
//            $action->execute($model)
//
//        }

//        return true;
//        $next = function ($model) use (&$next){
//
//            if ($this->rules->isEmpty()){
//                return true;
//            }
//
//            $nextRules = $this->rules->shift();
//
//            return $this->rulesFactory->make($nextRules)->handle($model,$next);
//        };
//
//        return $this->rulesFactory->make($firstRule)->handle($model,$next);
    }

    public function remove(): void
    {

    }
}
