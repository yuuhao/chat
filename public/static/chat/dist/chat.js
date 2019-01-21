var wsServer,ws;
wsServer = 'ws://192.168.10.10:5200';
ws = new WebSocket(wsServer);

function showUsers(data) {

    console.log(data)
    for (client in data.others) {
        var info = JSON.parse(data.others[client]);
        layim.addList({
            type: 'friend'
            , avatar: info.avatar
            , username: info.name
            , groupid: 3
            , id: info.id
            , client_id: info.client_id
            , remark: "本人冲田杏梨将结束AV女优的工作"
        });
    }

}
function webSocket() {
    ws.onopen = function (evt) {
        console.log("Connection success");
        ws.send(JSON.stringify({cmd: 'login', data: user}))
        ws.send(JSON.stringify({cmd: 'getOnline',data:user}));
    }

    ws.onmessage = function (event) {

        var data = JSON.parse(event.data);

        if (data.cmd == 'getOnline') {
            showUsers(data.clients)

        } else if (data.cmd == 'message') {

            layim.getMessage(data.from)

        } else if (data.cmd == 'login') {

            user.client_id = data.data.client_id;
        }
    }

    ws.onclose = function (event) {

    }
}
