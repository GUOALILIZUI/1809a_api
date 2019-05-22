<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Model\CompanyModel;

class CompanyController extends Controller
{
    //用户展示
    public function companyList()
    {

        $id = Auth::id();
        $info=DB::table('company')->where(['uid'=>$id])->first();
        $user=DB::table('users')->where('id',$id)->first(['name']);

        return view('company.companylist',['info'=>$info,'user'=>$user]);

    }

    public function listDo(Request $request){
        $id = Auth::id();
        $company_id=$request->input('id');
//        print_r($company_id);die;
        $info=DB::table('company')->where(['uid'=>$id,'company_id'=>$company_id])->first();
        $status=$info->company_status;
        $appid=$info->appid;
        $key=$info->key;
        if($status==1){
            $response=[
                'errno'=>0,
                'status'=>$status,
                'msg'=>'appid：'.$appid.'，key：'.$key.'，注意：获取token值时 在接口连接上输入相对应的 appid 与 key值'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            $response=[
                'errno'=>2,
                'msg'=>'审核未通过 , 不能获取appid 和 key',
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }


    }

    public function token(Request $request){
        $info=CompanyModel::where('appid',$_GET['appid'])->first();
        $company_id=$info->company_id;
        $token=substr(Str::random(15).time(),2,15);
        $ip=$_SERVER['SERVER_ADDR'];
        $redisKey='520zk_token_'.$ip;
        Redis::incr($redisKey);
        Redis::expire($redisKey,60);

        $info=DB::table('company')->where(['company_id'=>$company_id])->update(['access_token'=>$token]);
        if($info){
            $response=[
                'status'=>12,
                'msg'=>'获取成功',
                'access_token'=>$token,
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else if(empty($info)) {
            $response=[
                'status'=>11,
                'msg'=>'获取失败',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE)) ;
        }

    }

    //IP
    public function IP(){
        $ip=$_SERVER['SERVER_ADDR'];
        if($ip){
            $response=[
                'status'=>0,
                'msg'=>'IP：'.$ip,
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else if(empty($info)) {
            $response=[
                'status'=>1,
                'msg'=>'ip获取失败',
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{

        }
    }

    //UA
    public function UA(){
        $ua=$_SERVER['HTTP_USER_AGENT'];

        if($ua){
//            $ua=$_SERVER['HTTP_USER_AGENT'];
            $response=[
                'status'=>0,
                'msg'=>'UA：'.$ua,
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else if(empty($info)) {
            $response=[
                'status'=>1,
                'msg'=>'UA获取失败',
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{

        }
    }

    //注册视图
    public function comReg(){
        return view('company.comreg');
    }

    //注册数据
    public function regDo(Request $request){
        $info = $request->all();
        $business=$info['business_license'];
        $fileName= $this->upload($request,'business_license');

        $EnterPrise=$request->input('Enterprise_name');
        $Corporate=$request->input('Corporate_name');
        $number=$request->input('card_number');



        //验证用户
        if(empty($EnterPrise)){
            echo ('名');die;
        }else if(empty($Corporate)){
            echo ('法人');die;
        }else if(empty($number)){
            echo ('卡号');die;
        }
        $uid=Auth::id();

        //入库
        $data=[
            'Enterprise_name'=>$EnterPrise,
            'Corporate_name'=>$Corporate,
            'card_number'=>$number,
            'business_license'=>$fileName,
            'uid'=>$uid
        ];
        $company_id=DB::table('company')->insertGetId($data);
        if($company_id){
            $response=[
                'status'=>0,
                'msg'=>'注册成功',
            ];
            header("Refresh:5;url='companylist'");
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

    //处理图片
    public function upload(Request $request,$filename){
        if ($request->hasFile($filename) && $request->file($filename)->isValid()) {
            $photo = $request->file($filename);
            // $extension = $photo->extension();
            // $store_result = $photo->store('photo');
            $store_result = $photo->store('uploads/'.date('Ymd'));
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

}
