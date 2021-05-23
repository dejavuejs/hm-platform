<?php

namespace Ecommvu\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use Ecommvu\Product\Models\ProductProxy;
use Ecommvu\Marketing\Contracts\Template as TemplateContract;

class Template extends Model implements TemplateContract
{
    protected $table = 'marketing_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'content',
    ];
}