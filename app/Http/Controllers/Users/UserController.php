<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        $search = request()->only('search');
        $users = $this->userService->paginatedUsers($search);

        return inertia('Users/Index', [
            'filters' => $search,
            'users' => $users,
        ]);
    }

    public function create()
    {
        return inertia('Users/Create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = $this->userService->create($request->only([
            'name',
            'email',
            'receive_email',
        ]));

        return redirect()->route('users.show', $user->id);
    }

    public function show($id)
    {
        $user = $this->userService->find($id);

        return inertia('Users/Show', [
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);

        return inertia('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->userService->find($id);

        $this->userService->update($user, $request->only([
            'name',
            'email',
            'receive_email',
        ]));

        return redirect()->route('users.show', $user)->with('success', 'User has been updated');
    }

    public function destroy($id): RedirectResponse
    {
        $user = $this->userService->find($id);

        $this->userService->delete($user);

        return redirect()->route('users.index')->with('success', 'User has been removed');
    }
}
