<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Backend\TypeCreateRequest;
use App\Http\Requests\Backend\TypeUpdateRequest;
use App\Models\InterfaceTypeable;
use App\Models\Type;
use App\Repositories\TypeRepository;
use App\Transformers\Backend\TypeTransformer;
use Illuminate\Http\Request;

class TypesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Type $type)
    {
        return $this->response()->item($type, new TypeTransformer());
    }

    public function index(Request $request)
    {
        $types = Type::byModel($request->get('model'))->ancient()->get();

        return $this->response()->collection($types, new TypeTransformer());
    }

    public function store(TypeCreateRequest $request, TypeRepository $typeRepository)
    {
        $typeRepository->create($request->validated());

        return $this->response()->noContent();
    }

    public function update(Type $type, TypeUpdateRequest $request, TypeRepository $typeRepository)
    {
        $typeRepository->update($request->validated(), $type);

        return $this->response()->noContent();
    }

    /**
     * 删除类型.
     *
     * @param Type    $type
     * @param Request $request
     *
     * @return \App\Support\Response\Response
     */
    public function destroy(Type $type, Request $request)
    {
        if (class_exists($type->model_name)) {
            $model = app($type->model_name);
            if ($model instanceof InterfaceTypeable) {
                if ($request->has('delete_relation')) {
                    // 需要删除关联数据
                    $model->byType($type)->delete();
                } else {
                    // todo 这里不允许为 null
                    // 关联数据中的type_id 置为null
                    // $model->byType($type)->update(['type_name' => null]);
                }
            }
        }
        $type->delete();

        return $this->response()->noContent();
    }
}
