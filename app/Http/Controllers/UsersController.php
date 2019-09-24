<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 显示个人中心页面
     * @param \App\Models\User $user
     * @return void
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    /**
     * 显示编辑个人资料页面
     * @param \App\Models\User $user
     * @return void
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    /**
     * 修改个人资料功能
     * @param UserRequest $request
     * @param \App\Models\User $user
     * @return void
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
