<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Email Template for Order Confirmation Email</title>

    <!-- Start Common CSS -->
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            font-family: Helvetica, arial, sans-serif;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        .backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }

        .main-temp table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            font-family: Helvetica, arial, sans-serif;
        }

        .main-temp table td {
            border-collapse: collapse;
        }
    </style>
    <!-- End Common CSS -->
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp"
       style="background-color: #d5d5d5;">
    <tbody>
    <tr>
        <td>
            <table width="600" align="center" cellpadding="15" cellspacing="0" border="0" class="devicewidth"
                   style="background-color: #ffffff;">
                <tbody>
                <!-- Start header Section -->
                <tr>
                    <td style="padding-top: 30px;">
                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                               class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                            <tbody>
                            <tr>
                                <td style="padding-bottom: 10px;">
                                    <a href="https://www.brend-instrument.ru/"><img
                                            src="https://brend-instrument.ru/img/logo-i-gray-262x97%201%20(1).png"
                                            alt="brend-instrument"/></a>
                                </td>
                            </tr>
                            {{--                            <tr>--}}
                            {{--                                <td style="font-size: 14px; line-height: 18px; color: #666666;">--}}
                            {{--                                    3828 Mall Road--}}
                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td style="font-size: 14px; line-height: 18px; color: #666666;">--}}
                            {{--                                    Los Angeles, California, 90017--}}
                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            {{--                            <tr>--}}
                            {{--                                <td style="font-size: 14px; line-height: 18px; color: #666666;">--}}
                            {{--                                    Phone: 310-807-6672 | Email: info@example.com--}}
                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            <tr>
                                <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                    <strong>Номер заказа:</strong> {{ $content['body']['id'] }} | <strong>Время заказа:</strong> {{ $content['body']['created_at'] }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- End header Section -->

                <!-- Start address Section -->
                <tr>
                    <td style="padding-top: 0;">
                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                               class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                            <tbody>
                            <tr>
                                <td style="width: 55%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                    Личные данные
                                </td>
                                {{--                                <td style="width: 45%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">--}}
                                {{--                                    Billing Address--}}
                                {{--                                </td>--}}
                            </tr>
                            <tr>
                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                    {{ $content['body']['user']['name'] }}  {{ $content['body']['user']['lastName'] }} {{ $content['body']['user']['fatherName'] }}
                                </td>
                                {{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">--}}
                                {{--                                    James C Painter--}}
                                {{--                                </td>--}}
                            </tr>
                            <tr>
                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                    {{ $content['body']['user']['phone'] }}
                                </td>
                                {{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">--}}
                                {{--                                    3939  Charles Street, Farmington Hills--}}
                                {{--                                </td>--}}
                            </tr>
                            <tr>
                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                    {{ $content['body']['user']['email'] }}
                                </td>
                                {{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
                                {{--                                    Michigan, 48335--}}
                                {{--                                </td>--}}
                            </tr>
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                    {{ $content['body']['user']['company'] }}--}}
{{--                                </td>--}}
{{--                                --}}{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                --}}{{--                                    Michigan, 48335--}}
{{--                                --}}{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                    {{ $content['body']['address']['address_1'] }}--}}
{{--                                </td>--}}
{{--                                --}}{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                --}}{{--                                    Michigan, 48335--}}
{{--                                --}}{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                    {{ $content['body']['address']['address_2'] }}--}}
{{--                                </td>--}}
{{--                                --}}{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                --}}{{--                                    Michigan, 48335--}}
{{--                                --}}{{--                                </td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                   {{ $content['body']['city'] }}
                                </td>
                                {{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
                                {{--                                    Michigan, 48335--}}
                                {{--                                </td>--}}
                            </tr>
                            <tr>
                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                    {{ $content['body']['notes'] }}
                                </td>
                                {{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
                                {{--                                    Michigan, 48335--}}
                                {{--                                </td>--}}
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- End address Section -->
                @foreach($content['body']['products'] as $product)
                <!-- Start product Section -->
                <tr>
                    <td style="padding-top: 0;">
                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                               class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                            <tbody>
                            <tr>
                                <td rowspan="4" style="padding-right: 10px; padding-bottom: 10px;">
                                    <img style="height: 80px;" src="https://back.brend-instrument.ru<?=  $product['item']['image'] ?>" alt="<?= $product['item']['name'] ?>"/>
                                </td>
                                <td colspan="2"
                                    style="font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                   <?= $product['item']['name'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                    Quantity:  <?= $product['item']['qty'] ?>
                                </td>
                                <td style="width: 130px;"></td>
                            </tr>
                            <tr>
                                <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                    <b style="color: #666666;"> <?= $product['item']['price'] ?></b> Total
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
                <!-- End product Section -->

                <!-- Start calculation Section -->
                <tr>
                    <td style="padding-top: 0;">
                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"
                               class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                            <tbody>
                            <tr>
                                <td rowspan="5" style="width: 55%;"></td>
                                <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                   Итого:
                                </td>
                                <td style="font-size: 14px; line-height: 18px; color: #666666; width: 130px; text-align: right;">
                                    {{ $content['body']['grant_total']}} ₽
                                </td>
                            </tr>
                            <!--<tr>-->
                            <!--    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;">-->
                            <!--        Shipping Fee:-->
                            <!--    </td>-->
                            <!--    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">-->
                            <!--        0  ₽-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <tr>
                                <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                  Общая сумма
                                </td>
                                <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                    {{ $content['body']['grant_total']}} ₽
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- End calculation Section -->

                <!-- Start payment method Section -->
{{--                <tr>--}}
{{--                    <td style="padding: 0 10px;">--}}
{{--                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0"--}}
{{--                               class="devicewidthinner">--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td colspan="2"--}}
{{--                                    style="font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">--}}
{{--                                    Payment Method (Bank Transfer)--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">--}}
{{--                                    Bank Name:--}}
{{--                                </td>--}}
{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">--}}
{{--                                    Account Name:--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">--}}
{{--                                    Bank Address:--}}
{{--                                </td>--}}
{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">--}}
{{--                                    Account Number:--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                    Bank Code:--}}
{{--                                </td>--}}
{{--                                <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">--}}
{{--                                    SWIFT Code:--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td colspan="2"--}}
{{--                                    style="width: 100%; text-align: center; font-style: italic; font-size: 13px; font-weight: 600; color: #666666; padding: 15px 0; border-top: 1px solid #eeeeee;">--}}
{{--                                    <b style="font-size: 14px;">Note:</b> Lorem ipsum dolor sit amet, consectetur--}}
{{--                                    adipiscing elit--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </td>--}}
{{--                </tr>--}}
                <!-- End payment method Section -->
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
