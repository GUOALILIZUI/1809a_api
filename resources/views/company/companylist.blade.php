<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>审核列表</title>
</head>
<body>

<h1>欢迎用户{{$user->name}}</h1>
    <table>
        <tr>
            <td>企业id</td>
            <td>{{$info->company_id}}</td>

        </tr>
        <tr>
            <td>企业名称</td>
            <td>{{$info->Enterprise_name}}</td>

        </tr>
        <tr>
            <td>法人代表</td>
            <td>{{$info->Corporate_name}}</td>

        </tr>
        <tr>
            <td>银行卡号</td>
            <td>{{$info->card_number}}</td>

        </tr>
        <tr>
            <td>状态</td>
            <td>
                @if($info->company_status==2)
                    审核中
                @else
                    审核成功
                @endif

            </td>
            <td><a href="javascript:;" class="ss" company_id='{{$info->company_id}}'>获取 appid 和 key</a></td>
        </tr>
{{--            <td>{{$v->business_license}}</td>--}}

            <td><a href="token?company_id={{$info->company_id}}" class="token">token</a></td>
            <td><a href="javascript:;" class="ip" company_id="{{$info->company_id}}" >获取IP</a></td>
            <td><a href="javascript:;" class="ua" company_id="{{$info->company_id}}" >获取UA</a></td>

    </table>
</body>
</html>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="layui/layui.js"></script>
<script>
    $(function(){
        layui.use('layer',function(){
            var layer=layui.layer;

        $('.ss').click(function(){
            var id = $(this).attr('company_id');
            $.ajax({
                url:'listDo',
                data:{id:id},
                type:'post',
                dataType:'json',
                success:function(msg){
                    if(msg.erron=='0'){
                        alert(msg.msg)
                    }else{
                        alert(msg.msg)

                    }
//                    console.log(msg)
                }
            })
         })

        $('.ua').click(function(){

            $.ajax({
                url:'UA',
                type:'post',
                dataType:'json',
                success:function(msg){
                    if(msg.status==0){
                        alert(msg.msg)
                    }else if(msg.status==1){
                        alert(msg.msg)

                    }
                }
            })

        })


        $('.ip').click(function(){
//            var id = $(this).attr('company');

                $.ajax({
                    url:'IP',
//                data:{id:id},
                    type:'post',
                    dataType:'json',
                    success:function(msg){
                        if(msg.status==0){
                            alert(msg.msg)
                        }else if(msg.status==1){
                            alert(msg.msg)

                        }
//                    console.log(msg)
                    }
                })

            })
        })
    })
</script>