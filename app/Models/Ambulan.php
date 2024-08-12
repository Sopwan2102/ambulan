<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulan extends Model
{
    use HasFactory;
    protected $table='ambulan';
    protected $fillable=["id","no_plat","biaya","lokasi","milik","fasilitas","surat_izin","gambar","status"];
    protected $primaryKey = 'ambulan_id';
}
