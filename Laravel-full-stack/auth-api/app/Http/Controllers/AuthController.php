<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //
    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = [
            'name' => $registerRequest->name,
            'email' => $registerRequest->email,
            'password' => $registerRequest->password,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->register($data);

            // $this->otpCodeInterface->deleteByEmail($data['email']);
            // $this->otpCodeInterface->store($otpCode);

            // Mail::to($data['email'])->send(new OTPCodeEmail($user->fullName, $code));

            DB::commit();

            return ApiResponse::sendResponse(true, [new UserResource($user)], 'Opération effectuée.', 201);
        } catch (\Throwable $th) {
            return ApiResponse::rollback($th);
        }
    }

    public function login(LoginRequest $loginRequest)
    {
        $data = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->login($data);
            DB::commit();

            if(!$user){
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'Nom d\'utilisateur ou mot de passe incorrecte !',
                    401
                );
            }

            return ApiResponse::sendResponse(
                $user,
                [],
                'Connexion éffectuée effectuée.',
                200
            );
        } catch (\Throwable $th) {
            return ApiResponse::rollback($th);
        }
    }

    public function checkOtpCode(Request $request){
        $data = [
            'email' => $request->email,
            'code' => $request->code,
        ];

        DB::beginTransaction();

        try {
            $user = $this->authInterface->checkOtpCode($data);
            DB::commit();

            if(!$user){
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'Code de confirmation invalide!',
                    200
                );
            }

            return ApiResponse::sendResponse(
                true,
                [new UserResource($user)],
                'Opération éffectuée.',
                200
            );
        } catch (\Throwable $th) {
            return ApiResponse::rollback($th);
        }
    }

    public function logout(){

        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->tokens()->delete();

        return ApiResponse::sendResponse(
            true,
            [],
            'Utilisaterus déconnecté',
            200
        );
    }
}
