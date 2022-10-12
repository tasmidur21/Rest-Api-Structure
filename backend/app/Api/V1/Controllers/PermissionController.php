<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Permission;
use App\Services\V1\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class PermissionController extends BaseController
{
    protected PermissionService $permissionService;
    public int $successCode = ResponseCode::HTTP_OK;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        /*$this->authorizeResource(Permission::class);*/
    }

    public function index(Request $request)
    {
        $data = $this->permissionService->getList($request);
        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    public function create(): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', []), $this->successCode);
    }

    public function store(Request $request): JsonResponse
    {
        $message = 'generic.successfully_created';

        $validateData = $this->permissionService->validator($request->all())->validate();

        $this->permissionService->createPermission($validateData);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function show(Permission $permission): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $permission), $this->successCode);
    }

    public function edit(Permission $permission): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $permission), $this->successCode);
    }

    public function update(Request $request, Permission $permission): JsonResponse
    {
        $message = 'generic.successfully_updated';

        $validateData = $this->permissionService->validator($request->all(), $permission->id)->validate();

        $this->permissionService->updatePermission($permission, $validateData);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $message = 'generic.object_deleted_successfully';

        $this->permissionService->deletePermission($permission);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function groupWisePermissions(Permission $permission): JsonResponse
    {
        $groupWisePermissions = Permission::all()->groupBy('table_name');

        return response()->json(responseBuilder($this->successCode, '', $groupWisePermissions), $this->successCode);
    }
}
