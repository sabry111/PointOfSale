<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');

    }

    public function index(Request $request)
    {

        $users = User::WhereHasRole('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($q) use ($request) {
                return $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orwhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(4);
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');

    }

    public function store(Request $request)
    {
        // dd($request->permissions);
        // dd(auth()->user());
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'img' => 'image|mimes:png,jpg,jpeg',
            'password' => 'required|confirmed|min:8',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['permissions']);

        if ($request->img) {
            $new_name = $request->img->hashName();
            Image::make($request->img)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_image/' . $new_name));

            $request_data['img'] = $new_name;
        }

        $user = User::create($request_data);
        $user->addrole('admin');
        $user->givePermissions($request->permissions);
        return redirect(route('dashboard.users.index'));
    }

    public function edit($id)
    {
        $user = User::findorfail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'img' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|max:191',
            'permissions' => 'required|min:1',
        ]);
        $request_data = $request->except(['permissions', 'img']);

        $old_name = User::findorfail($request->id)->img;

        if ($request->hasFile('img')) {
            if ($old_name != 'default.png') {
                Storage::disk('public_uploads')->delete('users_image/' . $old_name);
            }
            $new_name = $request->img->hashName();
            Image::make($request->img)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_image/' . $new_name));
            $request_data['img'] = $new_name;

        } else {

            $request_data['img'] = $old_name;

        }
        // $user = User::firstWhere('id', $request->id);
        // $user = User::where('id', $request->id)->first();
        $user = User::find($request->id);
        $user->update($request_data);

        $user->syncPermissions($request->permissions);
        return redirect(route('dashboard.users.index'));
    }

    public function destroy($id)
    {

        $user = User::find($id);
        $old_name = $user->img;

        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('users_image/' . $old_name);
        }

        $user = User::findorfail($id);
        $user->delete();

        return redirect(route('dashboard.users.index'));
    }
}
