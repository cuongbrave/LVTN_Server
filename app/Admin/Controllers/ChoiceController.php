<?php

namespace App\Admin\Controllers;

use App\Models\Choice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Question;

class ChoiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Choice';
    //protected $IdQuestionForm;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Choice());

        $grid->column('id', __('Id'));
        $grid->column('question_id', __('Question id'));
        $grid->column('choice_text', __('Choice text'));
        $grid->column('is_correct', __('Is correct'));
        $grid->column('choice_num', __('Choice num'));
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
        $show = new Show(Choice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('question_id', __('Question id'));
        $show->field('choice_text', __('Choice text'));
        $show->field('is_correct', __('Is correct'));
        $show->field('choice_num', __('Choice num'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Choice());
        //lấy id của question từ url
        $questionId = request()->get('question_id');
        // dd($questionId);

        $choice_num = null;
        if ($questionId) {
            //tính question_num mới dựa trên question_num của choice cuối cùng ứng với question_id từ url
            $choice = Choice::where('question_id', $questionId)->orderBy('choice_num', 'desc')->first();
            if ($choice) {
                $choice_num = $choice->choice_num;
                // dd($question_num);
            }
            $choice_num++;
        }


        $form->number('question_id', __('Question id'))->default($questionId);
        $form->text('choice_text', __('Choice text'))->rules('required');
        $form->switch('is_correct', __('Is correct'));
        $form->number('choice_num', __('Choice num'))->default($choice_num);

        //thêm sự kiện để chuyển hướng

        if ($questionId != null) {
            //sử lí sự kiện saved

            $form->saved(function (Form $form) use ($questionId) {
                return redirect('/admin/questions/' . $questionId . '');
            });
            //sử lí sự kiện creating
            // $form->saving(function (Form $form) use ($questionId) {
            //     return redirect('/admin/questions/' . $questionId . '');
            // });

        }

        return $form;
    }
}
