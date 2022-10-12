<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\V1\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UserController extends BaseController
{
    protected UserService $userService;
    public int $successCode = ResponseCode::HTTP_OK;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        /*$this->authorizeResource(User::class);*/
    }

    public function index(Request $request)
    {
        $data = $this->userService->getList($request);
        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $user), $this->successCode);
    }

    public function edit(User $user): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $user), $this->successCode);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $message = 'generic.successfully_updated';

        $validateData = $this->userService->validator($request->all(), $user->id)->validate();

        $this->userService->updateUser($user, $validateData);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function destroy(User $User): JsonResponse
    {
        $message = 'generic.object_deleted_successfully';

        $this->userService->deleteUser($User);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function userRoleIndex(User $user): JsonResponse
    {
        $userRoles = $user->roles()->pluck('roles.'.'code', 'roles.'.'id')->toArray() ?? [];

        $data = [
            'user_roles' => $userRoles,
            'user' => $user
        ];

        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    public function userRoleSync(Request $request, User $user): JsonResponse
    {
        $roles = $request->input('roles', []);

        $this->userService->syncUserRole($user, $roles);

        return response()->json(responseBuilder($this->successCode, 'Other Roles assignment is successful', []), $this->successCode);
    }

    public function userPermissionIndex(User $user): JsonResponse
    {
        $userPermissions = $user->permissions()->pluck('permissions.'.'key', 'permissions.'.'id')->toArray() ?? [];

        $data = [
            'user_permissions' => $userPermissions,
            'user' => $user
        ];

        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    public function userPermissionSync(Request $request, User $user): JsonResponse
    {
        $permissions = $request->input('permissions', []);

        $this->userService->syncUserPermission($user, $permissions);

        return response()->json(responseBuilder($this->successCode, 'Permission assignment to user is successful', []), $this->successCode);
    }
}
