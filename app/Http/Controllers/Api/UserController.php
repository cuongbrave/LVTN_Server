<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function login(Request $request)
    {

        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'avatar' => 'required',
                    'type' => 'required',
                    'open_id' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    // 'password' => 'required|min:6'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //validated lấy tất cả trường giá trị của user
            //có thể lưu trong database
            $validated = $validateUser->validated();    // Get the validated data
            $map = [];
            // Check if the user already exists
            //gg, fb, apple, phone
            $map['type'] = $validated['type'];
            $map['open_id'] = $validated['open_id'];
            $user = User::where($map)->first();


            //kiem tra nguoi dùng đã đăng nhập chưa 
            //nếu rỗng thì là không tồn tại người dùng // chưa register
            //sau đó lưu người dùng vào database lần đầu tiên
            if (empty($user->id)) {
                //người dùng chưa có trong database
                //them user vao db
                //token = id_user + random
                $validated["token"] = md5(uniqid() . rand(10000, 99999));
                //lưu lại thời gian tạo user
                $validated["created_at"] = Carbon::now();
                // $validated["password"] = Hash::make($validated["password"]);

                $userID = User::insertGetId($validated); //trả về id của user vừa tạo sau khi lưu vào database

                $userInfo = User::where("id", "=", $userID)->first();    // Get the user info

                $accessToken = $userInfo->createToken(uniqid())->plainTextToken; // Create a token for the user

                $userInfo->access_token = $accessToken; // Assign the token to the user info

                User::where("id", "=", $userID)->update(["access_token" => $accessToken]); // Update the user info with the token

                return response()->json([
                    'code' => 200,
                    'msg' => 'User Created Successfully',
                    'data' => $userInfo
                ], 200);

            }

            //user previously has logged in
            $accessToken = $user->createToken(uniqid())->plainTextToken; // Create a token for the user
            $user->access_token = $accessToken; // Assign the token to the user info
            User::where("open_id", "=", $validated['open_id'])->update(["access_token" => $accessToken]);

            return response()->json([
                'code' => 200,
                'msg' => 'User logged in Successfully',
                'data' => $user
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


}
