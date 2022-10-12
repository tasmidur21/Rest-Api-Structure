<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Role;
use App\Services\V1\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

/**
 *
 */
class RoleController extends BaseController
{
    /**
     * @var RoleService
     */
    protected RoleService $roleService;
    /**
     * @var int
     */
    public int $successCode = ResponseCode::HTTP_OK;

    /**
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        $filterValidateData = $this->roleService->filterValidation($request)->validate();
        $data = $this->roleService->getList($filterValidateData);
        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getDetails($id);
        return response()->json(responseBuilder($this->successCode, '', $role), $this->successCode);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $message = 'successfully_created';

        $validateData = $this->roleService->validator($request)->validate();

        $createdRole = $this->roleService->createRole($validateData);

        return response()->json(responseBuilder(ResponseCode::HTTP_CREATED, $message, $createdRole->toArray() ?? []), ResponseCode::HTTP_CREATED);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $message = 'successfully_updated';

        $role = Role::findOrFail($id);

        $validateData = $this->roleService->validator($request, $id)->validate();

        $roleUpdatedData = $this->roleService->updateRole($role, $validateData);

        return response()->json(responseBuilder($this->successCode, $message, $roleUpdatedData->toArray()), $this->successCode);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $message = 'generic.object_deleted_successfully';

        $this->roleService->deleteRole($role);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }


    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function rolePermissionIndex(Role $role): JsonResponse
    {
        $rolePermissions = $role->permissions->pluck('key', 'id')->toArray() ?? [];

        $data = [
            'role_permissions' => $rolePermissions,
            'role' => $role
        ];

        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function rolePermissionSync(Request $request, Role $role): JsonResponse
    {
        $permissions = $request->input('permissions', []);

        $this->roleService->syncRolePermission($role, $permissions);

        return response()->json(responseBuilder($this->successCode, 'Permission assignment is successful', []), $this->successCode);
    }
}
