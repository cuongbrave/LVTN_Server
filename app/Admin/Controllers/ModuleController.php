<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Module;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ModuleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Module';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Module());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name Module'));
        $grid->column('description', __('Description'));
        $grid->column('course_id', __('Course id'));
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
        $show = new Show(Module::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name Module'));
        $show->field('description', __('Description'));
        $show->field('course_id', __('Course id'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));
        $show->test('Test', function ($test) {
            $test->resource('/admin/tests');
            $test->id();
            $test->module_id();
            $test->name();
            $test->description();
            $test->time();

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
        $form = new Form(new Module());

        //lấy id của course từ url
        $courseId = request()->get('course_id');
        $form->number('course_id', __('Course id'))->default($courseId);

        //lay danh sach khoa hoc
        // $result = Course::pluck('name', 'id');
        // $form->select('course_id', __('Course id'))->options($result);

        $form->text('name', __('Name Module'));
        $form->text('description', __('Description'));

        if ($courseId != null) {
            //sử lí sự kiện saved

            $form->saved(function (Form $form) use ($courseId) {
                return redirect('/admin/courses/' . $courseId . '');
            });

        }

        return $form;
    }
}
