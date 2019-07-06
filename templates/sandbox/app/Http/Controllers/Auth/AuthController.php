<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\User;
use App\Models\Admin\UserPermission;
use App\Models\Admin\Permission;
use Auth;
use Validator;

class AuthController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    private function getUserData(){
        $userId = Auth::user()->id;
        $user = User::where('id', '=', $userId)->with('userPermissions.permission')->first();
        return response()->json($user);
    }

    public function register(Request $request){
        $user = $this->user->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ], 401);
            }
        } catch(JWTException $e) {
            return response()->json([
                'error' => 'Something went wrong'
            ], 500);
        }

        $userId = JWTAuth::toUser($token)->id;

        $user = User::find($userId, ['name', 'email', 'active']);
        $permissions = Permission
            ::whereHas("permissionUsers", function($q) use ($userId){
                $q->where("user_id", "=", $userId);
            })
            ->pluck('code');
        
        if($user->active){
            return response()->json([
                'token' => $token,
                'user' => $user,
                'permissions' => $permissions
            ], 200);
        }
        else {
            return response()->json([
                'error' => 'User inactive'
            ], 401);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status' => 0
        ], 200);
    }

    public function getUser(Request $request){
        return $this->getUserData();
    }

    public function editUser(Request $request){

        $user = Auth::user();
        $user->update($request->only('name', 'email'));
        
        return $this->getUserData();
    }

    public function editUserPassword(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old' => 'required|string|hash:'.$user->password,
            'new' => 'required|string|min:8|different:old',
            'repeat' => 'required|string|min:8|same:new',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $user->fill([
            'password' => Hash::make($request->get('new'))
        ])->save();
        return ['status' => 1];
    }

    public function refreshToken(Request $request)
    {
        $oldToken = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($oldToken);
        return response()->json([
            'token' => $newToken,
        ], 200);
    }
}
