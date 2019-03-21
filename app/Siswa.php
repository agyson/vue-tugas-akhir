<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  public $table = 't_siswa';

  protected $fillable = ['nis', 'nama_lengkap','jenis_kelamin','alamat', 'id_kelas'];

  public function kelas(){
    return $this->belongsTo('App\Kelas', 'id_kelas');
  }

}
