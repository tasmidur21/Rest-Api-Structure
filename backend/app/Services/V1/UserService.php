<?php

namespace App\Services\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserService
{
    public function validator(array $postData, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($postData, $this->validationRules($id));
    }

    public function validationRules(int $id = null): array
    {
        $rules = [];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'user_type_id' => ['nullable', 'integer', 'min:1'],
            'role_id' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
        ];

        if (!$id) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        return $rules;
    }

    public function deleteUser(User $user): ?bool
    {
        return $user->delete();
    }

    public function updateUser(User $user, array $postData)
    {
        return $user->update($postData);
    }

    public function getList(Request $request, $conditions = [])
    {
        return User::where($conditions)->get();
    }

    public function syncUserRole(User $user, array $roles): User
    {
        $user->roles()->sync($roles);
        return $user;
    }

    public function syncUserPermission(User $user, array $permissions): User
    {
        $user->permissions()->sync($permissions);
        return $user;
    }
}
