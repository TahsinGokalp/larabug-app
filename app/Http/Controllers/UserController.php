<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(['id', 'name', 'email'])
            ->latest('created_at')
            ->paginate(6);

        return inertia('Users/Index', [
            'filters' => request()->only('search'),
            'users' => $users,
        ]);
    }

    public function create()
    {
        return inertia('Users/Create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $fields = $request->only([
            'name',
            'email',
            'receive_email',
        ]);
        $fields['password'] = Hash::make(Str::random(25));
        $user = User::create($fields);

        return redirect()->route('users.show', $user->id);
    }

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return inertia('Users/Show', [
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return inertia('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect()->route('users.show', $user)->with('success', 'User has been updated');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User has been removed');
    }

}
