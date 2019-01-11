<?php
/**
 * Created by yuuhao bigyuhao@163.com.
 * User: yuhao
 * Date: 2018/12/17
 * Time: 16:07
 */

namespace App\Chat;

use \Swoole\swoole_websocket_server;

class ChatHandle
{

    public function __construct()
    {

    }

    //监听WebSocket连接打开事件
    public function onOpen($ws, $request)
    {
        var_dump($request->fd, $request->get, $request->server);
        $ws->push($request->fd, "hello, welcome\n");
    }

    //监听WebSocket消息事件
    public function onMessage($ws, $frame)
    {
        echo "Message: {$frame->data}\n";
        $ws->push($frame->fd, "server: {$frame->data}");
    }

    //监听WebSocket连接关闭事件
    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
    }

}