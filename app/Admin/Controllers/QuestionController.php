<?php

namespace App\Admin\Controllers;

use App\Models\Question;
use App\Models\Test;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Question';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

        $grid->column('id', __('Id'));
        $grid->column('question_text', __('Tên câu hỏi'));
        $grid->column('test_id', __('Test id'));
        $grid->column('question_num', __('Câu hỏi số'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        return $grid;
    }

    /** 
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Question::findOrFail($id));

        // Thêm nút quay lại Test
        $show->panel()
            ->tools(function ($tools) use ($show) {
                $tools->append('<a href="/admin/tests/' . $show->getModel()->test_id . '" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Back to Test</a>');
            });

        $show->field('test_id', __('Test id'));
        $show->field('test.name', __('Tên bài thi'));
        // $show->field('id', __('Id'));
        $show->field('question_text', __('Tên câu hỏi'));

        $show->field('question_num', __('Câu hỏi số'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        $show->choice('Choices', function ($choice) {
            $choice->resource('/admin/choices');
            // $choice->id();
            // $choice->question_id();
            $choice->choice_num();
            $choice->choice_text();
            $choice->is_correct();
            // $choice->created_at();
            // $choice->updated_at();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Question());
        //lấy id của test từ url
        $testId = request()->get('test_id');

        $question_num = null;
        if ($testId) {
            //tính question_num mới dựa trên question_num của choice cuối cùng ứng với question_id từ url
            $question = Question::where('test_id', $testId)->orderBy('question_num', 'desc')->first();
            if ($question) {
                $question_num = $question->question_num;
                // dd($question_num);
            }
            $question_num++;
        }

        $result = Test::pluck('name', 'id');
        //$form->select('test_id', __('Test id'));
        $form->number('test_id', __('Test id'))->default($testId);

        $form->textarea('question_text', __('Tên câu hỏi'))->rows(5)->rules('required');
        $form->number('question_num', __('Câu hỏi số'))->default($question_num);


        if ($testId != null) {
            //sử lí sự kiện saved

            $form->saved(function (Form $form) use ($testId) {
                return redirect('/admin/tests/' . $testId . '');
            });
            //sử lí sự kiện creating
            // $form->saving(function (Form $form) use ($questionId) {
            //     return redirect('/admin/questions/' . $questionId . '');
            // });

        }


        return $form;
    }
}
