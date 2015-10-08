<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Http\Controllers\Controller;

/**
 * AdminBaseController.
 */
class AdminBaseController extends Controller
{
    public function index()
    {
        return 'Index';
    }

    /**
     * Save upload image from request file into uploads folder
     *
     * @param string $path
     * @param UploadedFile $file
     *
     * @return string
     */
    public function imageUpload($path, $file)
    {
        $dir = config("uploads.$path");
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $name = $file->getClientOriginalName();
        while (file_exists($dir.$name)) {
            $name = (rand(10, 99))."_".$name;
        }
        $file->move($dir, $name);
        return $name;
    }

    /**
     * Remove image from uploads folder
     *
     * @param string $path
     * @param string $filename
     *
     * @return boolean
     */
    public function imageRemove($path, $filename)
    {
        $dir = config("uploads.$path");
        if (file_exists($dir.$filename)) {
            unlink($dir.$filename);
            return true;
        }
        return false;
    }
}
