<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Backend\UserCreateRequest;
use App\Http\Requests\Backend\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\Backend\UserTransformer;
use Auth;

class UsersController extends ApiController
{
    // use Authorizable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 当前登录的用户信息.
     *
     * @return \App\Support\Response\TransformerResponse
     */
    public function me()
    {
        return $this->response()->item(Auth::user(), new UserTransformer());
    }

    /**
     * 用户列表.
     *
     * @return \App\Support\Response\TransformerResponse
     */
    public function index()
    {
        $users = User::withSimpleSearch()
            ->withSort()
            ->recent()
            ->paginate($this->perPage());

        return $this->response()->paginator($users, new UserTransformer())->setMeta(User::getAllowSortFieldsMeta() + User::getAllowSearchFieldsMeta());
    }

    public function store(UserCreateRequest $request, UserRepository $userRepository)
    {
        $userRepository->create($request->validated());

        return $this->response()->noContent();
    }

    /**
     * 显示指定用户信息.
     *
     * @param User $user
     *
     * @return \App\Support\Response\TransformerResponse
     */
    public function show(User $user)
    {
        return $this->response()->item($user, new UserTransformer());
    }

    public function update(User $user, UserUpdateRequest $request, UserRepository $userRepository)
    {
        $userRepository->update($request->validated(), $user);

        return $this->response()->noContent();
    }

    /**
     * 删除指定用户.
     *
     * @param User $user
     *
     * @return \App\Support\Response\Response
     */
    public function destroy(User $user)
    {
        // todo 用户关联的数据
        $user->delete();

        return $this->response()->noContent();
    }
}
