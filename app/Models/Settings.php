<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('site_name', 'region_name', 'contract_num', 'contractor_name', 'contractor_supervisor');

}