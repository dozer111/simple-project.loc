$(function () {

    var status=$('#status');
    var message=$('#message');
    var btnSay=$('#say');
    var btnExit=$('#exit');
    var status=$('#status');

    // 1 соединяемся с сервером
    var socket=new WebSocket("ws://echo.websocket.org");
        // 1a проверяем установку соединения с сервером
    socket.onopen=function () {
        console.log('Connection with server success!');
        status.text('Active connection').attr('class','status_success');
    }

        //1б
    socket.onclose=function (event) {
        console.log('Wrong connection!');
        status.text('Wrong connection').attr('class','status_wrong');

        // статус код ошибки
        var code=event.code;
        // причина ошибки
        var reason=event.reason;
        // а была ли вообще какая-то ошибка в принципе? @return bool
        var clean=event.wasClean;


        // делаю более кореектный вывод, почему закрыто соединение
        if(clean)
        {
            status.text('Wrong connection correct' );
        }
        else
        {
            status.text('Wrong connection because of code '+code+' and reason '+reason);
        }


    }


    socket.onmessage=function (event) {

        // данные ответа сервера

        var data=event.data;
        var dataType='';
        if(data[0]!=='{') dataType='string';
        if(dataType=='string')
        {
            $('#textarea').append(data);
            $('#textarea').append("<br />");

        }
        else
        {
            let jsonData=JSON.parse(data);
            let userName=jsonData.userName;
            let message=jsonData.message;
            $('#textarea2').append(`${userName} : ${message} `);
            $('#textarea2').append("<br />");
        }

    }


    /*
    ====================================================================================================================
    Отправляю и принимаю с сервера данные, Json методом
    ====================================================================================================================
     */
    $('#sayJson').on('click',function () {
        let userName=$('#username').val();
        var message=$('#message').val();

        let serverMessage={
            userName:userName,
            message:message
        };

        socket.send(JSON.stringify(serverMessage));

    });




    btnExit.on('click',function () {
        socket.close();

    });


    // 2 посылаем сообщение
    btnSay.on('click',function () {

        if(socket.readyState === WebSocket.OPEN)
        socket.send(message.val());

    });




});