<?php
/**
 * Created by yuuhao bigyuhao@163.com.
 * User: yuhao
 * Date: 2018/12/7
 * Time: 17:32
 */

namespace App\Servers;


class UserServers
{

    public $name = 'admin';
    public function getUsers(){
        return [1,23,3];
    }
}