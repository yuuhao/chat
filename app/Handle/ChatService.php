<?php
/**
 * Created by yuuhao bigyuhao@163.com.
 * User: yuhao
 * Date: 2018/12/20
 * Time: 12:47
 */

namespace App\Handle;

use Illuminate\Support\Facades\Redis;
class ChatService
{
    public function __construct()
    {
    }

    //用户登陆，在redis中将uid 和 fd 匹配
    public function login($server,$frame,$data){

        Redis::sadd('users',$data['data']['id']);
        $data['data']['client_id'] = $frame->fd ;
        Redis::set('user:'.$data['data']['id'],json_encode($data['data']));

        $server->push($frame->fd,json_encode($data));
    }

    //获取该用户所有好友
    public function firends(){

    }

    public function storeUser($request){
        Redis::sadd('clients',$request->fd);
        Redis::set('client:'.$request->fd,$request->fd);
    }

    //获取在线好友
    public function getOnline($server,$frame,$data){

        $result['cmd'] = 'getOnline';//不包含自己
        $id = $data['data']['id'];

        $userIds =Redis::smembers('users');

        $fds = Redis::smembers('clients');
        var_dump($fds);


        foreach ($fds as $fd){

            $result['clients'] = [];

            foreach ($userIds as $userId){

                $user = json_decode( Redis::get('user:'.$userId),true);
                if($fd == $user['client_id']){

                    $result['clients']['mine'] = Redis::get('user:'.$userId);

                }else{
                    $result['clients']['others'][] = Redis::get('user:'.$userId);
                }
            }

            $server->push($fd,json_encode($result));
        }
    }

    public function getAllOnline(){
        return Redis::smember('clients');
    }

    //单聊
    public function singleChat($server,$data){

        $clien_id = json_decode(Redis::get('user:'.$data['data']['to']['id']))->client_id;
        $result = [
            'cmd' => 'message',
            'from' => $data['data']['from']
        ];
        $server->push($clien_id,json_encode($result));
    }

    public function chat($server,$data){
        if($data['data']['from']['type'] === 'friend'){
            $this->singleChat($server,$data);
        }else if($data['data']['from']['type'] === 'group'){

        }

    }
    //群聊
    public function groupChat(){

    }
    //系统通知
    public function systemNotify(){

    }

    public function addFriend($server,$data){

    }

    public function deleteUser($fd){
        Redis::srem('clients',$fd);
        Redis::del('client:'.$fd);
    }

}