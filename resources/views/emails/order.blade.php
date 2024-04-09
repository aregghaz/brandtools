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

@foreach($content['body']['products'] as $product)
    <p>
        <p >
        <?php echo $product['item']['name'] ?>

        </p>
        <p>
{{--            <img width={120} src={`${fakeUrl}${item.item.image}`} alt={item.item.name}/>--}}
        </p>
        <p>
            <span >price : </span>
                <?php echo $product['item']['price'] ?>

        </p>
        <p>
            <span>quantity : </span>
                <?php echo $product['item']['quantity'] ?>
        </p>
    </p>
@endforeach

{{--<p>Реквизиты </p>--}}
{{--<p>name: {{ $content['body']['address']['name'] }}</p>--}}
{{--<p>lastName: {{ $content['body']['address']['lastName'] }}</p>--}}
{{--<p>fatherName: {{ $content['body']['address']['fatherName'] }}</p>--}}
{{--<p>fatherName: {{ $content['body']['bik'] }}</p>--}}
{{--<p>Р/С: {{ $content['body']['pc'] }}</p>--}}
{{--<p>Юр адрес: {{ $content['body']['address'] }}</p>--}}
{{--<p>Комментарий: {{ $content['body']['notes'] }}</p>--}}
</body>
</html>

