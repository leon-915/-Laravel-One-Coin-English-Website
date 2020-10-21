<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remind Payment</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        h2 {
            color: #000;
            font-size: 25px;
            text-align: center;
            text-shadow: 0px 3px 15px #ddd;
        }

        h4 {
            color: #333333;
            margin-left: 23px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            margin: 0px auto 20px auto;
            < !-- border: 1px solid #ddd;
        -->display: table;
        }

        th,
        td {
            text-align: center;
            padding: 10px 20px;
            font-size: 15px;
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2
        }

        th {
            background-color: #F47224;
            color: white;
        }

        p {
            margin: 0px;
            text-align: center;
            font-size: 15px;
        }

        table a {
            background-color: #bf1e2e;
            border-radius: 5px;
            color: #ffffff;
            padding: 10px;
            text-decoration: none;
        }

        table img {
            width: 80%;
        }

        img.brand_icon {
            width: 75px;
        }

        .footer a {
            text-align: center;
            color: #F47224;
            text-decoration: none;
        }

        .footer {
            text-align: center;
        }

        .footer p {
            margin-bottom: 10px;
        }

        table.buyer_detail th {
            background: transparent;
            color: #000;
            < !-- text-align: right;
        -->
        }

        table.buyer_detail td {
            text-align: left;
            width: 50%;
            padding-left: 20px;
            /*text-align: center;*/
        }

        tr.image-line {
            background: transparent;
            border: none !important;
        }

        tr.image-line td {
            padding: 0;
        }

        tr.image-line td img {
            width: 100%;
        }

        .top-4 img {
            margin-top: -4px;
        }

        .bottom-4 img {
            margin-bottom: -4px;
        }

        table.tbl_order {
            width: 80%;
        }

        td.item_tbl {
            padding: 25px 0px !important;
            background: #ededed;
        }

        th.head_tbl {
            font-size: 20px;
            padding: 15px 0px;
        }

        .tbl_order th {
            background-color: #EDEDED;
            color: #000;
            border-bottom: 1px dashed #d3d3d3;
        }

        table.tbl_order td {
            padding: 10px 10px;
        }

        tr.order-head td:first-child {
            text-align: left;
            font-weight: bold;
        }

        tr.detail_item {
            background: #f7f7f7;
        }

        tr.detail_item tr th {
            border-bottom: 1px dashed #ededed;
            background: transparent;
        }

        tr.detail_item tr {
            background: none;
        }

        td.top-4 {
            top: -5px;
            position: relative;
        }

        table.buyer_detail tr {
            background: transparent;
        }

        table.buyer_detail tr {
            background: transparent;
        }

        td.buyer_head {
            font-size: 20px;
            font-weight: bold;
            /*text-align: center !important;*/
            padding-left: 20px !important;
            background: transparent;
            border-bottom: 1px dashed #d3d3d3;
        }

        table.buyer_detail {
            width: 80%;
        }

        @media only screen and (max-width: 850px) {
            body {
                width: 100% !important;
            }
            td.top-4 {
                top: -10px;
            }
        }

        @media only screen and (max-width: 610px) {
            table.item_detail {
                width: 95%;
                border-collapse: collapse;
                border-spacing: 0;
                display: block;
                position: relative;
            }
            table.item_detail tbody {
                display: block;
                width: auto;
                position: relative;
                overflow-x: auto;
                white-space: nowrap;
            }
            table.buyer_detail {
                width: 100%;
            }
            .tbl_order th,
            tr.order-head td:first-child {
                text-align: left;
                padding-left: 10px !important;
            }
        }

        @media only screen and (max-width: 410px) {
            table.buyer_detail {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                display: block;
                position: relative;
            }
            table.buyer_detail tbody {
                display: block;
                width: auto;
                position: relative;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body style="margin:30px auto; width:850px;text-align:center;">
<div style="align:center; border:1px solid #ccc; padding-top:30px; padding-bottom:40px">

    <h4 style="margin-top: 35px;color: #333333;margin-left: 23px;"></h4>
    <div class="wrapper" style="text-align:left;font-size:18px;margin: 0 auto; width: 750px;">
        <p>Hi {{$reminder['user']['first_name']}},</p>
        <p>Description: {{$reminder['expiry_date']}},</p>
    </div>

</div>
@include('emails.footer')

</body>

</html>