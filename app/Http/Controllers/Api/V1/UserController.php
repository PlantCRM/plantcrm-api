<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::select('id', 'name', 'email')->get();
        return ProfileResource::collection($users)
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        return (new ProfileResource($user))
            ->additional(['message' => trans('user.create.success')])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * @param string $name
     * @return JsonResponse
     */
    public function show(string $name): JsonResponse
    {
        return (new ProfileResource(User::select('id', 'name', 'email')->where('name', $name)->first()))
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @param EditUserRequest $request
     * @param string $name
     * @return JsonResponse
     */
    public function update(EditUserRequest $request, string $name): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::where('name', $name)->first();
        $user->update($validatedData);
        $user->save();

        return (new ProfileResource($user))
            ->additional(['message' => trans('user.update.success')])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @param string $name
     * @return JsonResponse
     */
    public function delete(string $name): JsonResponse
    {
        $user = User::where('name', $name)->first();
        $user->delete();

        return (new ProfileResource($user))
            ->additional(['message' => trans('user.delete.success')])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }
}
