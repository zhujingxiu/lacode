<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
class MenuController extends Controller
{
    /**
     * 显示文章列表.
     *
     * @return Response
     */
    public function index()
    {
        $page_title = '商户菜单管理';
        $menus = Menu::where('role',['merchant'])->with(['parent'])->paginate(20);
        return view('/admin/permission/menu', compact('page_title','menus'));
    }


    /**
     * 将新创建的文章存储到存储器
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 显示指定文章
     *
     * @param int $id
     * @return Response
     */
    public function detail($id)
    {
        //
    }


    /**
     * 从存储器中移除指定文章
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        //
    }

}
