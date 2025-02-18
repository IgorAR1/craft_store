<?php

namespace App\Services;

use App\Enums\ActionType;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    public function __construct(public Activity $activity)
    {}
//    public ?string $initiator;
//    public string $subject ;
//
//    public ActionType $action;
//
//    public function initiateBy(User $user = null): self
//    {
//        $this->initiator = $user?->getKey();
//
//       return $this;
//    }
//
//    public function onSubject(Model $subject): self
//    {
//        $this->subject = $subject->getKey();
//
//        return $this;
//    }
//
//    public function withAction(ActionType $action): self
//    {
//        $this->action = $action;
//
//        return $this;
//    }
//    public function toArray()
//    {
//        return get_object_vars($this);
//    }

    public function log(ActionType $action):void{

        $activity = $this->activity;

        $activity->action = $action;

        $activity->save();
    }

    public function performedOn(Model $model): static {

        $this->activity->entity()->associate($model);

        return $this;
    }

    public function initiateBy(Model $model = null): static {

        $this->activity->initiator_id = $model?->getKey();

        return $this;
    }

}
