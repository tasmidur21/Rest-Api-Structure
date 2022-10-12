<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends BaseModel
{
    protected $table = 'permission_user';

    protected $guarded = ['id'];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
