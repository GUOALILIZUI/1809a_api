<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>企业注册</title>
</head>
<body>
<form action="/regDo" enctype="multipart/form-data" method="post" >
    <p>
        企业名称
        <input type="text" name="Enterprise_name">
    </p>
    <p>
        法人代表
        <input type="text" name="Corporate_name">
    </p>
    <p>
        银行卡号
        <input type="text" name="card_number" id="">
    </p>
    <p>
        营业执照
        <input type="file" name="business_license" id="">
    </p>
    <p>
        <input type="submit" value="REGISTER">
    </p>
</form>
</body>
</html>