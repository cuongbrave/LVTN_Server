<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\CourseType;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;

class CourseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Course';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    //
    protected function grid()
    {
        $grid = new Grid(new Course());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Course Name'));
        $grid->column('description', __('Description'));
        $grid->column('user_token', __('User token'));
        $grid->column('course_type_id', __('Course type id'));
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

    //hiển thị chi tiết
    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Course Name'));
        $show->field('description', __('Description'));
        $show->field('user_token', __('User token'));
        $show->field('course_type_id', __('Course type id'));
        //$show->field('created_at', __('Created at'));
        //$show->field('updated_at', __('Updated at'));
        // $show->module('Module', function ($module) {
        //     $module->resource('/admin/modules');
        //     $module->id();
        //     $module->course_id();
        //     $module->name();
        //     $module->description();
        //     //$module->created_at();
        //     //$module->updated_at();
        // });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form

     */

    //tạo và chỉnh sửa form
    protected function form()
    {
        $form = new Form(new Course());

        // Lấy danh sách course type
        $result = CourseType::pluck('title', 'id');
        $form->select('course_type_id', __('Categories'))->options($result);

        $form->text('name', __('Name'));
        $form->text('description', __('Description'));

        // Lấy danh sách admin users
        $result = Administrator::pluck('name', 'remember_token');
        $form->select('user_token', __('Teacher'))->options($result);
        // $result = User::pluck('name', 'token');
        // $form->select('user_token', __('Teacher'))->options($result);
        return $form;
    }
}
