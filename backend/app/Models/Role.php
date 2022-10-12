<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Role extends BaseModel
{
    protected $guarded = ['id'];

    public function users(): Builder
    {
        $userModel = User::class;

        return $this->belongsToMany($userModel, 'role_user')
            ->select(app($userModel)->getTable() . '.*')
            ->union($this->hasMany($userModel))->getQuery();
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
