<?php

namespace App\Services\V1;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionService
{
    public function deletePermission(Permission $permission): ?bool
    {
        return $permission->delete();
    }

    public function validator(array $postData, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($postData, $this->validationRules($id));
    }

    public function validationRules(int $id = null): array
    {
        return [
            'prefix' => ['required', 'string', 'max:50'],
            'key' => ['required', 'string', 'max:191', 'unique:permissions,key,' . $id],
            'table_name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'sub_group' => ['nullable', 'string', 'max:191'],
            'sub_group_order' => ['nullable', 'numeric']
        ];
    }

    public function createPermission(array $postData)
    {
        return Permission::create($postData);
    }

    public function updatePermission(Permission $permission, array $postData)
    {
        return $permission->update($postData);
    }

    public function getList(Request $request, $conditions = [])
    {
        return Permission::where($conditions)->get();
    }
}
