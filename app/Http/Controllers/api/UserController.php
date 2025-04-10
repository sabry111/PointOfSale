<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_update'])->only('update');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::whereHasRole('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($q) use ($request) {
                return $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orwhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);
        $users = UserCollection::make($users);
        return response()->json(['data' => $users, 'error' => ''], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request_data = $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'required|confirmed|min:8',
            'permissions' => 'required|array|min:1',
        ]);

        $request_data = $request->except(['permissions', 'img']);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $path = public_path('uploads/users_image/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $new_name = $file->hashName();
            $file->move($path, $new_name);
            $image = Image::make($path . $new_name);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save();
            $request_data['img'] = $new_name;
        }
        $user = User::create($request_data);
        $user->addrole('admin');
        $user->givePermissions($request->permissions);
        $user = UserResource::make($user);
        return response()->json(['data' => $user, 'error' => ''], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request_data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'permissions' => 'required|array|min:1',
        ]);
        $request_data = $request->except(['permissions', 'img']);
        $old_name = $user->img;
        if ($request->hasFile('img')) {
            if ($old_name != 'default.png') {
                Storage::disk('public_uploads')->delete('users_image/' . $old_name);
            }
            $file = $request->file('img');
            $path = public_path('uploads/users_image/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $new_name = $file->hashName();
            $file->move($path, $new_name);
            $image = Image::make($path . $new_name);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save();
            $request_data['img'] = $new_name;
        } else {

            $request_data['img'] = $old_name;
        }
        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        $user = UserResource::make($user);
        return response()->json(['data' => $user, 'error' => ''], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $old_name = $user->img;
        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('users_image/' . $old_name);
        }
        $user->delete();
        return response()->json([
            'data' => null,
            'message' => 'User deleted successfully.',
            'error' => ''
        ], 200);
    }
}
