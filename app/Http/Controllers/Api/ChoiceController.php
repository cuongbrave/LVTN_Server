<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Choice;

class ChoiceController extends Controller
{
    //Danh sach cau tra loi cua 1 cau hoi where question_id = ?? (cần đối số)
    public function answerList(Request $request)
    {
        $question_id = $request->question_id;
        try {
            $result = Choice::select('id', 'choice_text', 'is_correct', 'choice_num', 'question_id')
                ->where('question_id', '=', $question_id)->get();

            if ($result->isNotEmpty()) {
                return response()->json(
                    [
                        'code' => 200,
                        'msg' => 'Day la cac cau tra loi cho cau hoi nay',
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'msg' => 'Answer not found',
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
