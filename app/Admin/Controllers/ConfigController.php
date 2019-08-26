<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
class ConfigController extends Controller
{
    public function index()
    {
        $page_title = '系统设置';
        return view('admin.config.index', compact('page_title'));
    }

    public function store()
    {

    }

}
