<?php
/**
 * Created by yuuhao bigyuhao@163.com.
 * User: yuhao
 * Date: 2018/12/19
 * Time: 15:40
 */

namespace App\Handle;

use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Illuminate\Support\Facades\Redis;
use Auth;
class WebSocketService implements WebSocketHandlerInterface
{
    protected $cartServer;
    protected $name;
    public function __construct()
    {
            $this->cartServer = app()->make('App\Handle\ChatService') ;
    }

    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        \Log::info('New WebSocket connection', [$request->fd, $request->get["sessionid"], session()->getId(), auth()->id(), session(['yyy' => time()])]);
        $this->cartServer->storeUser($request);


    }
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        \Log::info('Received message', [$frame->fd, $this->name, $frame->opcode, $frame->finish]);

        $data = Fliter::filterArray(json_decode($frame->data,true));

        // 根据cmd 来区分请求

        switch ($data['cmd']){
            case 'login':
                $this->cartServer->login($server,$frame,$data);
                break;
            case 'getOnline':
                $this->cartServer->getOnline($server,$frame,$data);
                break;
            case 'send':
                $this->cartServer->Chat($server,$data);
                break;
            default:
                return ;
        }
    }

    public function onClose(\swoole_websocket_server $server, $fd, $reactorId)
    {
        $this->cartServer->deleteUser($fd);
    }
}