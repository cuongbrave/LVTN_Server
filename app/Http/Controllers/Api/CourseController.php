<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //return all course list
    public function courseList()
    {
        $result = Course::select('id', 'name', 'description', 'user_token', 'course_type_id')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Course List is here',
            'data' => $result
        ]);
    }

    //return all course list
    public function courseDetail(Request $request)
    {
        $id = $request->id;
        try {
            $result = Course::where('id', '=', $id)->select(
                'id',
                'name',
                'description',
                'user_token',
                'course_type_id',

            )->first();

            if ($result) {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Course Detail is here',
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'msg' => 'Course not found',
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
                    'data' => $e->getMessage()
                ],
                500
            );
        }

    }
}
