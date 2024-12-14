<?php

namespace App\Admin\Controllers;

use App\Models\Painters;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Paintings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Admin\Controllers\Painting;

static $counter = 0;

class PainterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Painters';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Painters());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('bio', __('Bio'));
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
        $show = new Show(Painters::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('bio', __('Bio'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        // $counter = 0;
        // $totalRows = DB::table('paintings')->count();

        $show->paintings('Paintings', function ($paintings) {
            $paintings->resource('/admin/paintings');

            $paintings->model()->orderBy('order', 'asc');

            //$totalRows = DB::table('paintings')->count();
            //$counter = $totalRows;
            // Thêm cột đánh số thứ tự
            // $paintings->column('STT', __('STT'))->display(function () use (&$counter) {
            //     return $counter;
            // });
            // for ($i = 1; $i <= $totalRows; $i++) {
            //     $counter++;

            // }
            $paintings->id();
            $paintings->painter_id();
            $paintings->order();
            $paintings->title();
            $paintings->body();
            // $paintings->created_at();
            // $paintings->updated_at();


            // Hiển thị tổng số hàng kết quả

        });


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    // protected function form()
    // {
    //     $form = new Form(new Painters());

    //     $form->text('name', __('Name'));
    //     $form->textarea('bio', __('Bio'));
    //     $form->saved(function (Form $form) {
    //         // Sau khi edit xong sẽ chuyển hướng về trang danh sách
    //         return redirect('/admin/painters');
    //     });

    //     return $form;
    // }

    protected function form()
    {
        $form = new Form(new Painters());

        $form->text('name', __('Name'));
        $form->textarea('bio', __('Bio'));


        return $form;
    }


    public function destroy($id)
    {
        $painter = Painters::findOrFail($id);
        $relatedPaintings = Paintings::where('painter_id', $id)->count();

        if ($relatedPaintings > 0) {
            return response()->json([
                'message' => 'This painter has related paintings. Are you sure you want to delete?',
                'confirm' => true
            ]);
        }

        $painter->delete();

        return response()->json([
            'message' => 'Painter deleted successfully.'
        ]);
    }


}
