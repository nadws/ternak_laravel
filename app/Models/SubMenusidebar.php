<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenusidebar extends Model
{
    use HasFactory;
    protected $table = 'tb_sub_menu';
    protected $fillable = [
        'id_menu', 'sub_menu', 'url'
    ];
}
