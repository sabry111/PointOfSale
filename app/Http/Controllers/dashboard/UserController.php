<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\MediaLibrary\Models\Media;

class UserController extends Controller
{

    public function __construct()
    {

        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit','update');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereHasRole('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($q) use ($request) {
                return $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orwhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {

        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
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
        return redirect(route('dashboard.users.index'));
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
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
        return redirect(route('dashboard.users.index'));
    }

    public function destroy(Request $request, User $user)
    {

        $old_name = $user->img;

        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('users_image/' . $old_name);
        }
        $user->delete();
        return redirect(route('dashboard.users.index'));
    }
}
