<?php

namespace App\Admin\Controllers\Company;

use App\Model\CompanyModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyModel);

        $grid->company_id('Company id');
        $grid->Enterprise_name('Enterprise name');
        $grid->Corporate_name('Corporate name');
        $grid->card_number('Card number');
        $grid->business_license('Business license')->display(function($img){
            return '<img src="/'.$img.'" width="60" high="60" >' ;
        });
        $grid->uid('Uid');
        $grid->appid('Appid');
        $grid->key('Key');
        $grid->access_token('Access token');
        $grid->company_status('审核状态')->switch();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CompanyModel::findOrFail($id));

        $show->company_id('Company id');
        $show->Enterprise_name('Enterprise name');
        $show->Corporate_name('Corporate name');
        $show->card_number('Card number');
        $show->business_license('Business license');
        $show->uid('Uid');
        $show->appid('Appid');
        $show->key('Key');
        $show->access_token('Access token');
        $show->company_status('Company status');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CompanyModel);

        $form->number('company_id', 'Company id');
        $form->text('Enterprise_name', 'Enterprise name');
        $form->text('Corporate_name', 'Corporate name');
        $form->text('card_number', 'Card number');
        $form->text('business_license', 'Business license');
        $form->number('uid', 'Uid');
        $form->text('appid', 'Appid');
        $form->text('key', 'Key');
        $form->text('access_token', 'Access token');
        $form->text('company_status', 'Company status')->default('1');
        $states = [
            'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => '关闭', 'color' => 'default'],
        ];
        $form->switch('company_status','审核状态')->states($states);

        return $form;
    }

    public function  update($company_id,Request $request)
    {
        $company_status=$request->input('company_status');
        if($company_status=='on'){
            $status=1;
        }else{
            $status=2;
        }
        CompanyModel::where(['company_id'=>$company_id])->update(['company_status'=>$status]);

            $info=CompanyModel::where('company_id',$company_id)->update(['company_status'=>1]);

            if($info){
                //生成APPID
                $appid=substr(time().rand(9999,1000),2,11);
                //key
                $key=substr(rand(999,10000).Str::random(20),2,25);

                $data2=[
                    'appid'=>$appid,
                    'key'=>$key,
                ];
                CompanyModel::where('company_id',$company_id)->update($data2);
            }
    }
}
