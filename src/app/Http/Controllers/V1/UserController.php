<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserCreateRequest;
use App\Models\Position;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponses;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request);
        // sry, I am a little bit lazy for resource creation
        return response()->json($users);
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = $this->userService->createUser($validatedData, $request);

            return $this->success('New user successfully registered', 201, [
                'user_id' => $user->id
            ]);
        } catch (ValidationException $e) {
            return $this->validationError();
        } catch (UserAlreadyExistsException $e) {
            return $this->error('User with this phone or email already exist', 409);
        } catch (\Exception $e) {
            return $this->error('An unexpected error occurred.', 500);
        }
    }

    public function show(Request $request)
    {
        $id = $request->validate([
            'id' => 'required|exists:positions,id',
        ]);

        $user = User::where('id', $id)->first();

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
}
