<?php

namespace App\Models;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    const PENDING = 2;
    const DELETED = 99;
    const MOBILE_REGEX = "regex:/^01[0-9]{9}$/";

    public function save(array $options = []): bool
    {
        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($this->getAttribute('id')) {
                if (Schema::hasColumn($this->getTable(), 'updated_by')) {
                    $this->updated_by = $authUser->id;
                }
            } else {
                if (Schema::hasColumn($this->getTable(), 'created_by')) {
                    $this->created_by = $authUser->id;
                }
            }
        }

        return parent::save($options);
    }

    public function update(array $attributes = [], array $options = []): bool
    {
        if (Auth::check()) {
            $authUser = AuthHelper::getAuthUser();
            $connectionName = $this->getConnectionName();
            if (Schema::connection($connectionName)->hasColumn($this->getTable(), 'updated_by')) {
                $this->updated_by = $authUser->id;
            }
        }

        return parent::update($attributes, $options);
    }
}
