<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\UserType;
use App\Services\V1\UserTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UserTypeController extends BaseController
{
    protected UserTypeService $userTypeService;
    public int $successCode = ResponseCode::HTTP_OK;

    public function __construct(UserTypeService $userTypeService)
    {
        $this->userTypeService = $userTypeService;
        /*$this->authorizeResource(UserType::class);*/
    }

    public function index(Request $request)
    {
        $data = $this->userTypeService->getList($request);
        return response()->json(responseBuilder($this->successCode, '', $data), $this->successCode);
    }

    public function create(): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', []), $this->successCode);
    }

    public function store(Request $request): JsonResponse
    {
        $message = 'generic.successfully_created';

        $validateData = $this->userTypeService->validator($request->all())->validate();

        $this->userTypeService->createUserType($validateData);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function show(UserType $userType): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $userType), $this->successCode);
    }

    public function edit(UserType $userType): JsonResponse
    {
        return response()->json(responseBuilder($this->successCode, '', $userType), $this->successCode);
    }

    public function update(Request $request, UserType $userType): JsonResponse
    {
        $message = 'generic.successfully_updated';

        $validateData = $this->userTypeService->validator($request->all(), $userType->id)->validate();

        $this->userTypeService->updateUserType($userType, $validateData);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }

    public function destroy(UserType $userType): JsonResponse
    {
        $message = 'generic.object_deleted_successfully';

        $this->userTypeService->deleteUserType($userType);

        return response()->json(responseBuilder($this->successCode, $message, []), $this->successCode);
    }
}
