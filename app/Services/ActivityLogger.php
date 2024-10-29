<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function __construct(public Activity $activity)
    {}

    public function log(string $action):void{

        $activity = $this->activity;

        $activity->action = $action;

        $activity->save();
    }

    public function performedOn(Model $model): static {

        $this->activity->entity()->associate($model);

        return $this;
    }

    public function initiateBy(Model $model): static {

        $this->activity->initiator()->associate($model);

        return $this;
    }
}
