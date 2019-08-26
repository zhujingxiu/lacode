@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">登录记录</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <td></td>
                        <td>登录时间</td>
                        <td>ip</td>
                        <td>归属地</td>
                        <td>UA</td>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach($logs as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->ip}}</td>
                            <td>{{$item->locate}}</td>
                            <td>{{$item->user_agent}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$logs->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
