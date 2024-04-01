<!DOCTYPE html>
<html>
<head>
    <title></title>

    <!--
	You can put your custom CSS if you wish
    -->
</head>
<body>
<p>Заявка на счет</p>
<p></p>
<p>Имя: {{ $content['body']['name'] }}</p>
<p>Фамилия: {{ $content['body']['lastName'] }}</p>
<p>E-mail: {{ $content['body']['email'] }}</p>
<p>Телефон: {{ $content['body']['phone'] }}</p>
<p>Компания: {{ $content['body']['company'] }}</p>
<p>Реквизиты компании </p>
<p>ИНН: {{ $content['body']['ihh'] }}</p>
<p>КПП: {{ $content['body']['kpp'] }}</p>
<p>БИК: {{ $content['body']['bik'] }}</p>
<p>Р/С: {{ $content['body']['pc'] }}</p>
<p>Юр адрес: {{ $content['body']['address'] }}</p>
<p>Комментарий: {{ $content['body']['notes'] }}</p>
</body>
</html>
