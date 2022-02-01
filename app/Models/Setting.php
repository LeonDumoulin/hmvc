<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = [
        'site_name',
        'site_name_en',
        'region_name',
        'contract_num',
        'contractor_name',
        'contractor_name_en',
        'contractor_supervisor',
        'site_manager',
        'project_start_date',
        'total_budget',
        'hijri_project_start_date',
        'project_end_date',
        'hijri_project_end_date',
        'daily_cut_class_a',
        'daily_cut_class_b',
        'cut_operator_class_a',
        'cut_operator_class_b',
    ];

    public function getSiteNameAttribute($value)
    {
        return app()->getLocale() == 'en' ? $this->site_name_en : $value ;
    }
}