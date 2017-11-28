$(document).ready(function() {
    $('#btn_submit').click(function() { //Если нажата кнопка отправить, то работаем

        var url = $('#url').val(); //Читаем форму url
        var short   = $('#short').val(); //Читаем форму c коротким url

        $.ajax( { //Отправляем 
            url: "create.php", // отправка на эту страничку
            type: "post", // методом пост
            dataType: "json", // тип перадачи
            data: { // отправляемые данные
                "url":    url,
                "your_url":   short
            },
            success: function(data) { //получаем ответ от сервера
                $('.messages').html(data.result); // выводим ответ сервера
            }
        });
    });
});
