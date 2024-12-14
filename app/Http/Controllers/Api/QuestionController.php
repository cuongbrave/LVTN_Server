<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;


class QuestionController extends Controller
{

    //trả về 1 dánh sách câu hỏi của 1 bài test where test_id = ?? (cần đối số)
    //--> lưu vào 1 list[question] để hiển thị, đồng thời truy cập từng câu hỏi cụ thể
    public function questionList(Request $request)
    {
        $test_id = $request->test_id;
        try {
            $result = Question::select('id', 'question_text', 'question_num', 'test_id')->where('test_id', '=', $test_id)->get();

            if ($result->isNotEmpty()) {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Đây là danh sách câu hỏi của bài test này',
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'msg' => 'Question not found',
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

}
