<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
class ChatController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $user = json_encode(auth()->user());
        return view('chat.index',compact('user'));
    }

    ///初始化聊天界面的数据，返回格式固定
    public function init(){

        $id = auth()->id();
        $user = User::find($id);
        return $this->toFormat($user);
    }

    public function toFormat($data){
        $result = [
            'id' => $data->id,
            'username' => $data->name,
            'status' => 'online',
            'sign' => $data->sign,
            'avatar' => $data->avatar
        ];

        return $this->toJson($result);

    }

    public function toJson($item){
        $data = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'mine' => $item,
                'friend' => [
                    [
                        'groupname' => '好友',
                        'id' => 1,
                        'online' =>5,
                        'list' => []
                    ],
                    [
                        'groupname' => '在线用户',
                        'id' => 3,
                        'online' =>2,
                        'list' => []
                    ],
                ]
            ]
        ];

        return response()->json($data);
    }

    public function getChatlog($send_id,$receive_id){
        
    }

    public function find(){

        $users = User::query()->where('id','<>',auth()->id());
        if( $filter = request('search','')){
            $users->orWhere('id',$filter);
        }

        $users = $users->get();
        return view('chat.find',compact('users'));
    }

    public function addFirend(){

    }
}
