<?php

namespace Orca\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Orca\Category\Contracts\CategoryTranslation as CategoryTranslationContract;

class CategoryTranslation extends Model implements CategoryTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'locale_id'];
}