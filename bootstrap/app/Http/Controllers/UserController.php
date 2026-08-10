<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display list users
     */
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $users = User::whereRaw(
                    "MATCH(name, email) AGAINST(? IN BOOLEAN MODE)",
                    [$keyword]
                )
                ->paginate(10)
                ->withQueryString();
        } else {
            $users = User::query()
                ->paginate(10)
                ->withQueryString();
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function store(StoreRequest $request)
    {
        $dataReq = $request->validated();

        $data = [
            'name'     => $dataReq['name'],
            'email'    => $dataReq['email'],
            'password' => Hash::make($dataReq['password']),
            'role_id'  => $dataReq['role_id'],
        ];

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function update(UpdateRequest $request, User $user)
    {
        $dataReq = $request->validated();

        $user->name = $dataReq['name'];
        $user->email = $dataReq['email'];
        $user->role_id = $dataReq['role_id'];

        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}