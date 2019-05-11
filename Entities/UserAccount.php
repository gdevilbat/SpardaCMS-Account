<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = "user_account";
    protected $primaryKey = "user_id";

    public function user()
    {
    	return $this->belongsTo("Gdevilbat\SpardaCMS\Modules\Core\Entities\User","user_id");
    }
}
