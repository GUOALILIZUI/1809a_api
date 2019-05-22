<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    //
    protected $table="company";
    public $timestamps=false;
    protected  $primaryKey="company_id";
}
