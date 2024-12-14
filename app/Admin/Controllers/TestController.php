<?php

namespace App\Admin\Controllers;

use App\Models\Module;
use App\Models\Test;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Admin\Actions\GenerateQrCode;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;







class TestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Test';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Test());

        // $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('test_code', __('Test code'));
        $grid->column('description', __('Description'));
        $grid->column('time', __('Time'));
        // $grid->column('module_id', __('Module id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->actions(function ($actions) {
            $actions->add(new GenerateQrCode());
        });



        return $grid;
    }

    //QR code creater
    public function generateQrCode($id)
    {
        $test = Test::findOrFail($id);
        $qrCode = QrCode::size(300)->generate($test->test_code);

        return view('admin.qrcode.show', compact('qrCode', 'test'));
    }

    // public function downloadQrCode($id)
    // {
    //     $test = Test::findOrFail($id);
    //     $qrCode = QrCode::format('png')->size(300)->generate($test->test_code);

    //     // Tạo đối tượng ảnh từ mã QR
    //     $image = Image::make($qrCode)->encode('png');

    //     // Tùy chỉnh (ví dụ: thêm watermark hoặc text)
    //     $image->text('Test: ' . $test->name, 150, 150, function ($font) {
    //         $font->size(18);
    //         $font->color('#FF0000');
    //         $font->align('center');
    //         $font->valign('top');
    //     });

    //     // Lưu vào thư mục storage/public
    //     $fileName = 'qrcode_' . $test->test_code . '.png';
    //     Storage::disk('public')->put($fileName, $image);

    //     // Trả về URL hoặc file tải xuống
    //     return response()->download(storage_path("app/public/{$fileName}"))->deleteFileAfterSend(true);
    // }

    public function downloadQrCode($id)
    {
        $test = Test::findOrFail($id);
        $qrCode = QrCode::format('png')->size(300)->generate($test->test_code);

        // Tạo đối tượng Imagick từ mã QR
        $image = new \Imagick();
        $image->readImageBlob($qrCode);

        // Tùy chỉnh (ví dụ: thêm watermark hoặc text)
        $draw = new \ImagickDraw();
        $pixel = new \ImagickPixel('red');
        $draw->setFillColor($pixel);
        $draw->setFontSize(18);
        $image->annotateImage($draw, 10, 20, 0, 'Test: ' . $test->name);

        // Lưu vào thư mục storage/public
        $fileName = 'qrcode_' . $test->test_code . '.png';
        $filePath = storage_path("app/public/{$fileName}");
        $image->writeImage($filePath);

        // Trả về URL hoặc file tải xuống
        return response()->download($filePath)->deleteFileAfterSend(true);
    }




    // public function generateQrCode($id)
    // {
    //     $test = Test::findOrFail($id);

    //     // Tạo mã QR Code
    //     $qrCode = QrCode::format('png')->size(300)->generate($test->test_code);

    //     // Tạo đối tượng ảnh từ mã QR
    //     $image = Image::make($qrCode);

    //     // Tùy chỉnh (ví dụ: thêm watermark hoặc text)
    //     $image->text('Test: ' . $test->name, 150, 150, function ($font) {
    //         $font->size(18);
    //         $font->color('#FF0000');
    //         $font->align('center');
    //         $font->valign('top');
    //     });

    //     // Lưu vào thư mục storage/public
    //     $fileName = 'qrcode_' . $test->test_code . '.png';
    //     Storage::disk('public')->put($fileName, $image->stream());

    //     // Trả về URL hoặc file tải xuống
    //     return response()->download(storage_path("app/public/{$fileName}"))->deleteFileAfterSend(true);
    // }




    // public function downloadQrCode($id)
    // {
    //     $test = Test::findOrFail($id);
    //     $qrCode = QrCode::format('png')->size(300)->generate($test->test_code);
    //     $fileName = 'qrcode_' . $test->test_code . '.png';
    //     Storage::disk('public')->put($fileName, $qrCode);

    //     return response()->download(storage_path("app/public/{$fileName}"))->deleteFileAfterSend(true);
    // }


    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Test::findOrFail($id));

        //$show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('time', __('Time'));
        // $show->field('user_token', __('User token'));
        // $show->field('module_id', __('Module id'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        $show->question('Question', function ($question) {
            $question->resource('/admin/questions');
            $question->model()->orderBy('question_num', 'asc');

            //$question->id();
            $question->question_num();
            $question->question_text();
            $question->test_id();
            // $question->module_id();
            // $question->name();
            // $question->description();
            // $question->time();

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
        $form = new Form(new Test());

        //lấy id của module từ url
        //$moduleId = request()->get('module_id');
        //$form->number('module_id', __('Module id'))->default($moduleId);

        //lay danh sach module
        // $result = Module::pluck('name', 'id');
        // $form->select('module_id', __('Module id'))->options($result);

        $form->text('name', __('Name'))->rules('required');
        $form->text('description', __('Description'))->rules('required');
        $form->text('time', __('Time'))->rules('required');
        $form->switch('recommend', __('Recommend'))->default(0);

        $result = Administrator::pluck('name', 'id');
        $form->select('user_token', __('Teacher'))->options($result)->rules('required');


        // if ($moduleId != null) {
        //     //sử lí sự kiện saved

        //     $form->saved(function (Form $form) use ($moduleId) {
        //         return redirect('/admin/modules/' . $moduleId . '');
        //     });

        // }
        return $form;
    }
}
