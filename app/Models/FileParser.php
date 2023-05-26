<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileParser extends Model
{
    protected $table = 'tb_parsers';

    protected $fillable = ['name_file', 'file_location'];

}
