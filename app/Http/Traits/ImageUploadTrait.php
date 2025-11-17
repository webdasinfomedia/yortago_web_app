<?php

namespace App\Http\Traits;

trait ImageUploadTrait
{

    public function upload_image($file)
    {
        $name = $file->getClientOriginalName();
        $name = str_replace(" ", "-", $name);
        $file->move('uploads/cms/', $name);
        return "uploads/cms/" . $name;
    }

    public function upload_file($file)
    {
        $name = $file->getClientOriginalName();
        $name = str_replace(" ", "-", $name);
        $file->move('uploads/exercise/', $name);
        return "uploads/exercise/" . $name;
    }
}
