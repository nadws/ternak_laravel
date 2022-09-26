<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menusidebar extends Model
{
    use HasFactory;
    protected $table = 'tb_menu';
    protected $fillable = [
        'id_menu', 'icon', 'menu'
    ];
}
