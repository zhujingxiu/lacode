<?php

namespace App\Http\Controllers\Merchant;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    //
    public $per_page = 10;
    public function index(){
        $notices = Notice::withTrashed()->paginate($this->per_page);
        return view('merchant.notice.index',compact('notices'));
    }

    public function create()
    {
        return view('merchant.notice.form');
    }

    public function update(Notice $notice)
    {
        return view('merchant.notice.form',compact('notice'));
    }

    public function delete(Notice $notice)
    {

        try {
            $notice->delete();
            if ($notice->trashed()) {

                return ajax_return(1, ['redirect' => route('merchant.notice')]);
            }
            return ajax_return(0);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function store(Request $request)
    {
        $notice_id = $request->input('notice');
        $tmp = [
            'content' => $request->input('content')
        ];
        $options = $request->input('option');
        foreach ($options as $option){
            $tmp[$option] = 1;
        }
        if($notice_id){
            $notice = Notice::find($notice_id);
            $notice->update($tmp);
        }else{
            $notice = Notice::create($tmp);
        }
        if($notice->id){
            return ajax_return(1,['redirect'=>route('merchant.notice')]);
        }
        return ajax_return(0);
    }
}
