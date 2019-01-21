<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查找用户</title>
    <link rel="stylesheet" href="{{ asset('/static/chat/dist/css/layui.css') }}">
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ asset('/static/chat/src/layui.js') }}"></script>
    <script src="{{ asset('/static/chat/dist/chat.js') }}"></script>

</head>
<body>
<div class="layui-row">
    <div class="layui-tab layui-tab-brief">
        <div class="layui-tab-content">
            <div class="layui-tab-item  layui-show ">
                <div style="width: 80%">
                    <input  style="float: left;width: 81%;" type="text" id="user-wd" required lay-verify="required" placeholder="请输入ID/昵称" autocomplete="off" class="layui-input"  >
                    <button onclick="findUser()" style="float: right;width: 17%"  class="layui-btn">
                        <i class="layui-icon">&#xe615;</i> 查找
                    </button>
                </div>
                <div class="layui-row">
                    @foreach($users as $k=>$v)
                        <div class="layui-col-md4" style="border-bottom: 1px solid #f6f6f6">
                            <div class="layui-card">
                                <div class="layui-card-header">{{ $v->name }}({{ $v->id }})</div>
                                <div class="layui-card-body">
                                    <img style="width: 75px;height: 75px;object-fit: cover;" src="{{ $v->avatar }}" alt="">
                                    <button onclick="addFriend({{ $v->id }},'{{ $v->name }}','{{ $v->avatar }}')" style="float: right" class="layui-btn layui-btn-normal layui-btn-sm">
                                        <i class="layui-icon">&#xe654;</i> 添加
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{--<div class="layui-tab-item @if($type == 'group')  layui-show @endif">
                <div>
                    <input  style="float: left;width: 80%;" type="text" id="group-wd" required lay-verify="required" placeholder="请输入群Id/群名称" autocomplete="off" class="layui-input" @if($type == 'group') value="{{ $wd }}" @endif>
                    <button onclick="createGroup()" style="float: right;width: 10%"  class="layui-btn layui-btn-warm">
                        <i class="layui-icon">&#xe654;</i> 创建群
                    </button>
                    <button onclick="findGroup()" style="float: left;width: 10%;margin-left: 0"  class="layui-btn">
                        <i class="layui-icon">&#xe615;</i> 查找群
                    </button>
                </div>
                @foreach($group_list as $k=>$v)
                    <div class="layui-col-md4" style="border-bottom: 1px solid #f6f6f6">
                        <div class="layui-card">
                            <div class="layui-card-header">{{ $v->groupname }}({{ $v->id }})</div>
                            <div class="layui-card-body">
                                <img style="width: 75px;height: 75px;object-fit: cover;" src="{{ $v->avatar }}" alt="">
                                <button onclick="joinGroup({{ $v->id }})" style="float: right" class="layui-btn layui-btn-normal layui-btn-sm">
                                    <i class="layui-icon">&#xe654;</i> 加入
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>--}}
        </div>
    </div>
</div>

<script>

    var layer;
    layui.use('layer', function(){
        layer = layui.layer;
    });
    layui.use('element', function(){
        var element = layui.element;
    });
    function findUser() {
        wd = $('#user-wd').val();
        window.location.href="/find?type=user&wd="+wd
    }

    function addFriend(id,nickname,avatar) {
        layui.use('layim', function(layim){
            layim.add({
                type: 'friend' //friend：申请加好友、group：申请加群
                ,username: nickname //好友昵称，若申请加群，参数为：groupname
                ,avatar: avatar //头像
                ,submit: function(group, remark, index){ //一般在此执行Ajax和WS，以通知对方
                    var data = {cmd:"addFriend",to_user_id:id,to_friend_group_id:group,remark:remark}
                    ws.send(JSON.stringify(data))
                    layer.close(index); //关闭改面板
                }
            });
        });
    }

</script>

