<?php

namespace Ecommvu\DNS\Models;

use Illuminate\Database\Eloquent\Model;

class DNS extends Model
{
    protected $table = 'domain_changes';

    protected $fillable = ['company_id', 'base', 'old', 'current', 'channel_id', 'status'];
}