<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Http\Controllers\Controller;

/**
 * AdminBaseController
 */

class AdminBaseController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Save upload image from request file into uploads folder
     *
     * @param file $file
     * @return string
     */
    public function imageUpload($file)
    {
        $dir = "uploads/";
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
     * @param string $filename
     * @return boolean
     */
    public function imageRemove($filename)
    {
        $dir = "uploads/";
        if (file_exists($dir.$filename)) {
            unlink($dir.$filename);
            return true;
        }
        return false;
    }
}
