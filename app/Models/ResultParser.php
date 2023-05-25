<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultParser extends Model
{
    protected $table = 'tb_parsers';

    protected $fillable = ['name_file', 'file_location'];

}
