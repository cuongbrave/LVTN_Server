<?php

namespace App\Admin\Controllers;

use App\Models\UserTest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserTestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserTest';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserTest());

        // $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('test_id', __('Test id'));
        $grid->column('score', __('Score'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('status', __('Status'));
        $grid->disableActions();
        $grid->disableCreateButton();
        //$grid->disableExport();


        $grid->filter(function ($filter) {
            $filter->like('test.test_code', 'Test Code'); // Tìm kiếm theo test_code từ quan hệ test
        });

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
        $show = new Show(UserTest::findOrFail($id));

        // $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('test_id', __('Test id'));
        $show->field('score', __('Score'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserTest());

        $form->number('user_id', __('User id'));
        $form->number('test_id', __('Test id'));
        $form->number('score', __('Score'));
        $form->text('status', __('Status'))->default('in_progress');

        return $form;
    }
}
