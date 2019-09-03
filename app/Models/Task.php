<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\Updater;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use Updater;
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
