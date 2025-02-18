<?php

namespace App\Services\Discount\Rules;

use App\Contracts\DiscountableContract;
use App\Contracts\DiscountCheckerInterface;
use App\Factories\DiscountRulesFactory;
use App\Models\Discount;
class RuleChecker implements DiscountCheckerInterface
{
    public function __construct(public readonly DiscountRulesFactory $rulesFactory)
    {
    }

    public function check(DiscountableContract $discountable, Discount $discount): bool
    {
        $rules = $discount->getRules();

        foreach ($rules as $rule) {
            $rule = $this->rulesFactory->make($rule->getType());
            if (!$rule->execute($discountable)) {
                return false;
            }
        }

        return true;
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

}
