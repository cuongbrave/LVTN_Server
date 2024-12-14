<?php

namespace App\Admin\Controllers;

use App\Models\Paintings;
// use App\Models\Painting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaintingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Paintings';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Paintings());

        $grid->column('id', __('Id'));
        $grid->column('painter_id', __('Painter id'));
        $grid->column('title', __('Title'));
        $grid->column('body', __('Body'));
        $grid->column('order', __('Order'));
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
        $show = new Show(Paintings::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('painter_id', __('Painter id'));
        $show->field('title', __('Title'));
        $show->field('body', __('Body'));
        $show->field('order', __('Order'));
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
        $form = new Form(new Paintings());
        $painterId = request()->get('painter_id');

        // Truy vấn để lấy giá trị order tương ứng với painter_id
        $order = null;
        if ($painterId) {
            $painting = Paintings::where('painter_id', $painterId)->orderBy('order', 'desc')->first();
            if ($painting) {
                $order = $painting->order;
            }
            $order++;
        }
        // dd($order, $painterId);

        $form->number('painter_id', __('Painter id'))->default($painterId);
        $form->text('title', __('Title'));
        $form->textarea('body', __('Body'));
        $form->number('order', __('Order'))->default($order);

        // Thêm sự kiện saved để chuyển hướng
        $form->saved(function (Form $form) {
            return redirect('/admin/painters'); // Chuyển hướng về trang painters sau khi edit thành công
            //return redirect()->back(); // Chuyển hướng về trang trước đó sau khi edit thành công
        });



        return $form;
    }



}
