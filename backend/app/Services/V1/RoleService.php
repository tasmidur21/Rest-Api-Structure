<?php

namespace App\Services\V1;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class RoleService
{

    /**
     * @param array $request
     * @return array
     */
    public function getList(array $request): array
    {
        $title = $request['title'] ?? null;
        $code = $request['code'] ?? null;
        $perPage = $request['limit'] ?? null;
        $pageNo = $request['page'] ?? null;
        $responseData = [];


        /** @var Builder $roleQueryBuilder */
        $roleQueryBuilder = Role::select([
            'roles.id as id',
            'roles.title',
            'roles.code',
            'roles.description',
            'roles.created_at',
            'roles.updated_at'
        ]);
        if (!empty($title)) {
            $roleQueryBuilder->where("roles.title", "like", "%$title%");
        }
        if (!empty($code)) {
            $roleQueryBuilder->where("roles.code", "like", "%$code%");
        }
        if (is_numeric($pageNo)) {
            $perPage = is_numeric($perPage) ? $perPage : 10;
            $paginatedData = $roleQueryBuilder->paginate($perPage)->toArray();
            $responseData['total'] = $paginatedData['total'];
            $responseData['current_page'] = $paginatedData['current_page'];
            $responseData['per_page_data'] = $perPage;
            $responseData['data'] = $paginatedData['data'];
        } else {
            $responseData = $roleQueryBuilder->get()->toArray();
        }

        return $responseData;
    }

    /**
     * @param int $id
     * @return Role
     */
    public function getDetails(int $id): Role
    {
        return Role::select([
            'roles.id as id',
            'roles.title',
            'roles.code',
            'roles.description',
            'roles.created_at',
            'roles.updated_at'
        ])->where("roles.id", $id)->firstOrFail();
    }

    /**
     * @param array $postData
     * @return Role
     */
    public function createRole(array $postData): Role
    {
        return Role::create($postData);
    }

    /**
     * @param Role $role
     * @param array $postData
     * @return Role
     */
    public function updateRole(Role $role, array $postData): Role
    {
        $role->update($postData);
        return $role;
    }

    /**
     * @param Role $role
     * @return bool|null
     */
    public function deleteRole(Role $role): ?bool
    {
        return $role->delete();
    }

    /**
     * @param Role $role
     * @param array $permissions
     * @return Role
     */
    public function syncRolePermission(Role $role, array $permissions): Role
    {
        $role->permissions()->sync($permissions);

        $role->users()->pluck('id')->each(function ($userId) {
            Cache::forget('userwise_permissions_' . $userId);
        });

        return $role;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title' => ['required', 'string', 'max:191'],
            'code' => ['required', 'string', 'max:191', 'unique:roles,code,' . $id],
            'description' => ['nullable', 'string']
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public function filterValidation(Request $request): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        $rules = [
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'title' => ['nullable', 'string', 'max:191'],
            'code' => ['nullable', 'string', 'max:191']
        ];
        return Validator::make($request->all(), $rules);
    }
}
