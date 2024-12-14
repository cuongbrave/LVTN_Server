<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTest;
use App\Models\UserChoice;
use App\Models\Choice;
use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'test_id' => 'required|exists:test,id',
                'results' => 'array',
                'status' => 'required|in:in_progress,submitted',
            ]);

            $testId = $validated['test_id'];
            $results = $validated['results'] ?? [];
            $status = $validated['status'];

            $existingTest = UserTest::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->first();

            if ($existingTest) {
                if ($existingTest->status === 'submitted') {
                    return response()->json([
                        'code' => 400,
                        'msg' => 'You have already submitted this test.',
                        'data' => [],
                    ], 400);
                }

                if ($status === 'submitted') {
                    $score = empty($results) ? 0 : $this->calculateScore($results);
                    return $this->submitTest($existingTest, $results, $score);
                }

                if ($status === 'in_progress') {
                    if (!empty($results)) {
                        $this->saveResults($existingTest, $results);

                        // Tính điểm từ kết quả
                        $score = $this->calculateScore($results);

                        // Cập nhật điểm cho bài kiểm tra
                        $existingTest->update(['score' => $score]);
                    }

                    $progress = $this->getProgress($existingTest->id);

                    return response()->json([
                        'code' => 200,
                        'msg' => 'Test is already in progress.',
                        'data' => [
                            'userTest' => $existingTest->refresh(),
                            'progress' => $progress,
                        ],
                    ], 200);
                }
            }

            if ($status === 'submitted') {
                $score = empty($results) ? 0 : $this->calculateScore($results);
                $userTest = UserTest::create([
                    'user_id' => Auth::id(),
                    'test_id' => $testId,
                    'score' => $score,
                    'status' => 'submitted',
                ]);

                if (!empty($results)) {
                    $this->saveResults($userTest, $results);
                }

                return response()->json([
                    'code' => 200,
                    'msg' => 'Test submitted successfully.',
                    'data' => $userTest,
                ], 200);
            }

            if ($status === 'in_progress') {
                $userTest = UserTest::create([
                    'user_id' => Auth::id(),
                    'test_id' => $testId,
                    'score' => 0,
                    'status' => 'in_progress',
                ]);

                return response()->json([
                    'code' => 200,
                    'msg' => 'Test started successfully.',
                    //'data' => $userTest,
                    'data' => [
                        'userTest' => $userTest,
                        'progress' => [], // Nếu không có dữ liệu trong progress thì sẽ trả về [].
                    ],

                ], 200);
            }
        } catch (\Exception $e) {
            \Log::error('Error storing test result: ' . $e->getMessage());

            return response()->json([
                'code' => 500,
                'msg' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    private function submitTest($userTest, $results, $score)
    {
        try {
            $userTest->update([
                'score' => $score,
                'status' => 'submitted',
                'updated_at' => now(),
            ]);

            $userTest->refresh();
            $this->saveResults($userTest, $results);

            return response()->json([
                'code' => 200,
                'msg' => 'Test submitted successfully.',
                'data' => $userTest,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error submitting test: ' . $e->getMessage());

            return response()->json([
                'code' => 500,
                'msg' => 'Error submitting test.',
                'data' => [],
            ], 500);
        }
    }

    private function saveResults($userTest, $results)
    {
        foreach ($results as $result) {
            UserChoice::updateOrCreate(
                [
                    'user_test_id' => $userTest->id,
                    'question_id' => $result['question_id'],
                ],
                [
                    'choice_id' => $result['choice_id'] ?? null,
                ]
            );
        }
    }

    private function calculateScore($results)
    {
        $score = 0;
        $questionIds = [];
        $choiceIds = [];

        foreach ($results as $result) {
            $choice = Choice::find($result['choice_id']);

            if (
                !in_array($result['question_id'], $questionIds) &&
                $choice &&
                $choice->is_correct &&
                !in_array($result['choice_id'], $choiceIds)
            ) {
                $questionIds[] = $result['question_id'];
                $choiceIds[] = $result['choice_id'];
                $score++;
            }
        }

        return $score;
    }

    private function getProgress($userTestId)
    {
        return UserChoice::where('user_test_id', $userTestId)
            ->get(['question_id', 'choice_id']);
    }
}
