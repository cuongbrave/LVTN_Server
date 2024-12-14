<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class GenerateQrCode extends RowAction
{
    public $name = 'QR Code';

    public function handle(Model $model)
    {
        // Logic để tạo QR code có thể được thêm vào đây nếu cần
    }

    public function href()
    {
        return route('admin.tests.qrcode', ['id' => $this->getKey()]);
    }
}