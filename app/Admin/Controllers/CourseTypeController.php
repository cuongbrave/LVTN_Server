<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\CourseType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;



class CourseTypeController extends AdminController
{
    public function index(Content $content)
    {
        $tree = new Tree(new CourseType());
        return $content
            ->header('CourseType')
            ->description('description')
            ->body($tree);
    }
    //protected $title = 'CourseType';
    //
    protected function detail($id)
    {
        $show = new Show(CourseType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('decriptions', __('Decriptions'));
        // $grid->column('password', __('Password'));
        $show->field('order', __('Orders'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new CourseType());

        $form->select('parent_id', __('Parent id'))->options(CourseType::selectOptions());  //check video 6 list 17
        $form->text('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->number('order', __('Order'));
        // $form->textarea('password', __('Password'));

        return $form;
    }

}
