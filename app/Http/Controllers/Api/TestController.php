<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;

//return all test list  (không cần đối số)
class TestController extends Controller
{
    public function testList()
    {
        $result = Test::select('id', 'name', 'description', 'user_token', 'time')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Test List is here',
            'data' => $result
        ]);
    }

    //return detail of a test (test id == ??) (cần đối số)-->sử dụng để truy cập 1 bài thi cụ thể
    public function testDetail(Request $request)
    {
        $id = $request->id;
        try {
            $result = Test::where('id', '=', $id)->select(
                'id',
                'name',
                'description',
                'user_token',
                'time',

            )->first();

            if ($result) {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Test Detail is here',
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'msg' => 'Test not found',
                        'data' => []
                    ],
                    404
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'code' => 500,
                    'msg' => 'Server Internal Error',
                    'data' => []
                ],
                500
            );
        }
    }


    public function testSearchDefault(Request $request)
    {
        try {
            $result = Test::where('recommend', '=', 1)
                ->select('id', 'name', 'description', 'user_token', 'time')
                ->get();

            if ($result->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'msg' => 'No recommended tests found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'msg' => 'The tests recommended for you',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching recommended tests: ' . $e->getMessage());

            return response()->json([
                'code' => 500,
                'msg' => 'Internal server error',
                'data' => []
            ], 500);
        }
    }

    public function testSearch(Request $request)
    {
        $search = $request->search;

        $result = Test::where("test_code", "like", "%$search%")
            // ->orWhere("name", "like", "%$search%")
            ->select('id', 'name', 'description', 'user_token', 'time')->get();

        return response()->json(
            [
                'code' => 200,
                'message' => 'The test search is here',
                'data' => $result
            ],
            200
        );

    }
}
