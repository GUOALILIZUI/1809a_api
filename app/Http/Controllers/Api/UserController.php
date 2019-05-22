<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{
    public function curlUser(){
        $url='http://1809a.apitest.com/jsonEncode';
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $cc=curl_exec($ch);
        $oo=curl_errno($ch);
        var_dump($oo);
    }

    //raw  3
    public function curlRaw(){
        $url='http://1809a.apitest.com/data';
        $dd='name=a&sex=女';
        $dataInit=curl_init();
        //传输数据
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$dd);
        curl_setopt($dataInit,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        //post传输
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        $cc=curl_exec($dataInit);
        print_r($cc);
    }

    //data  2
    public function curlData(){
        $url='http://1809a.apitest.com/data';
        $data=[
            'name'=>'hello world'
        ];
        // $info=json_encode($data);
        // print_r($data);exit;
        $dataInit=curl_init();
        //传输数据
        curl_setopt($dataInit,CURLOPT_URL,$url);
         //post传输
        curl_setopt($dataInit,CURLOPT_POST,1);

        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);

        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$data);

        $cc=curl_exec($dataInit);
        // $oo=curl_errno($dataInit);
        // var_dump($oo);
        print_r($cc);
    }

    //application/x-www-form-urlencoded  1
    public function curlenCoded(){
        $url='http://1809a.apitest.com/data';
        $post_str = "nickname=ccc&email=ccc@qq.com";
        // print_r($info);exit;
        $dataInit=curl_init();
        curl_setopt($dataInit,CURLOPT_URL,$url);
        curl_setopt($dataInit,CURLOPT_POST,1);
        //禁止浏览器输出 变量
        curl_setopt($dataInit, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($dataInit,CURLOPT_POSTFIELDS,$post_str);
        $cc=curl_exec($dataInit);
        print_r($cc);
    }

    public function WareTime(){

        echo "aa";
    }

}
