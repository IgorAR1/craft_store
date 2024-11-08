<?php

namespace App\Traits;

trait Bannable
{
    public function ban():void
    {
        $this->is_banned = true;
        $this->save();
    }

    public function unban():void
    {
        $this->is_banned = false;
        $this->save();
    }

    public function isBanned():bool
    {
        return $this->is_banned;
    }

}
