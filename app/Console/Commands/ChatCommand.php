<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Chat\ChatHandle;
class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:chat {option}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole_chat options command';

    protected $serv;
    protected $handle;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChatHandle $handle)
    {
        parent::__construct();
        //seting 参数问题
       // $this->serv = new \swoole_websocket_server('0.0.0.0','9501');
       // $this->handle = $handle;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->serv->on('open',[$this->handle,'onOpen']);

        $this->serv->on('message',[$this->handle,'onMessage']);

        $this->serv->on('close',[$this->handle,'onClose']);

        $this->serv->start();
    }
}
