<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultParser extends Model
{
    protected $table = 'tb_resultpars';

    protected $fillable = ['soal', 'a', 'b', 'c', 'd', 'e', 'jawaban', 'score', 'jenis'];

}
