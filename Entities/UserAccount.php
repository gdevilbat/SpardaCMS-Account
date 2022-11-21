<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = "user_account";
    protected $primaryKey = "user_id";

    protected $appends = [
        'avatar'
    ];

    public function user()
    {
    	return $this->belongsTo("Gdevilbat\SpardaCMS\Modules\Core\Entities\User","user_id");
    }

    public function getAvatarAttribute()
    {
        if(empty($this->profile_image_url))
            return module_asset_url('Core:assets/images/atomix_user31.png');

        return generate_storage_url($this->profile_image_url);
    }
}
