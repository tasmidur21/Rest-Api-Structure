<?php

namespace App\Services\V1;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserTypeService
{
    public function deleteUserType(UserType $userType): ?bool
    {
        return $userType->delete();
    }

    public function validator(array $postData, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($postData, $this->validationRules($id));
    }

    public function validationRules(int $id = null): array
    {
        return [
            'code' => ['required', 'string', 'max:191', 'unique:user_types,code,' . $id],
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'created_by' => ['nullable', 'integer'],
            'updated_by' => ['nullable', 'integer']
        ];
    }

    public function createUserType(array $postData)
    {
        return UserType::create($postData);
    }

    public function updateUserType(UserType $userType, array $postData)
    {
        return $userType->update($postData);
    }

    public function getList(Request $request, $conditions = [])
    {
        return UserType::where($conditions)->get();
    }
}
