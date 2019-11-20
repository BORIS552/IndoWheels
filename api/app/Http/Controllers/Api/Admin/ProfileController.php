<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    protected $user;

    public function __invoke(Request $request)
    {
        $this->user = $request->user();
        $this->updateName($request)
            ->updateEmail($request)
            ->updatePhone($request)
            ->updatePassword($request)
            ->updateAvatar($request);
        $this->user->save();
        return $this->user;
    }

    private function updateName(Request $request)
    {
        if (!isset($request->name)) {
            return $this;
        }

        $this->validate($request, [
            'name' => ['required'],
        ]);

        $this->user->name = $request->name;
        return $this;
    }

    private function updateEmail(Request $request)
    {
        if (!isset($request->email)) {
            return $this;
        }

        $this->validate($request, [
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
        ]);

        $this->user->email = $request->email;
        return $this;
    }

    private function updatePhone(Request $request)
    {
        if (!isset($request->phone)) {
            return $this;
        }

        $this->validate($request, [
            'phone' => ['required', Rule::unique('users')->ignore($this->user->id)],
        ]);

        $this->user->phone = $request->phone;
        return $this;
    }

    private function updatePassword(Request $request)
    {
        if (!isset($request->password)) {
            return $this;
        }

        $this->validate($request, [
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $this->user->password = bcrypt($request->password);
        return $this;
    }

    private function updateAvatar(Request $request)
    {
        if (!isset($request->avatar)) {
            return $this;
        }

        $this->validate($request, [
            'avatar' => ['required', 'file', 'image'],
        ]);

        $this->user->avatar = $request->avatar->store('avatars', 'public');
        return $this;
    }
}
