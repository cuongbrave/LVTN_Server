<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserTest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestExistController extends Controller
{
    public function testExist(Request $request)
    {
        $validated = $request->validate([
            'test_id' => 'required|exists:test,id',
        ]);

        $test_id = $validated['test_id'];
        $user_id = Auth::id();  // Lấy ID của user đã xác thực

        try {
            $result = UserTest::where('test_id', $test_id)
                ->where('user_id', $user_id)
                ->where('status', 'submitted')  // Chỉ kiểm tra bài đã nộp
                ->first();

            if ($result) {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Test exists',
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Test does not exist',
                        'data' => []
                    ],
                    200
                );
            }

        } catch (\Throwable $e) {
            // Ghi lại lỗi để dễ theo dõi trong môi trường phát triển
            Log::error("TestExist Error: " . $e->getMessage());

            return response()->json(
                [
                    'code' => 500,
                    'msg' => 'Internal Server Error',
                    'data' => []
                ],
                500
            );
        }
    }
}
