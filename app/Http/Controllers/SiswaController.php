<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Siswa;
use App\Kelas;

class SiswaController extends Controller
{
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'nis' => 'required|max:10',
      'nama_lengkap' => 'required|string',
      'jenis_kelamin' => 'required|max:1',
      'alamat' => 'required|string',
      'id_kelas' => 'required'
    ]);


    if($validation->fails()){
      $errors = $validation->errors();
      return [
        'status' => 'error',
        'message' => $errors,
        'result' => null
      ];
    }

    $checkIdKelas = Kelas::find($request->input('id_kelas'));

    if(count($checkIdKelas) == 0){
      return[
        'status' => 'error',
        'message' => 'ID Kelas not found.',
        'result' => null
      ];
    }


    $result = \App\Siswa::create($request->all());
    if($result) {
      return [
        'status' => 'success',
        'message' => 'Data berhasil ditambahkan',
        'result' => $result
      ];
    }else{
      return [
        'status' => 'success',
        'message' => 'Data gagal ditambahkan',
        'result' => null
      ];
    }
  }

  public function read(Request $request)
  {
    $result = \App\Siswa::all();

    foreach ($result as $record) {
      $record->kelas;
    }

    return [
      'status' => 'success',
      'message' => '',
      'result' => $result
    ];
  }

  public function update(Request $request, $id)
  {
    $validation = Validator::make($request->all(), [
      'nis' => 'required|max:10',
      'nama_lengkap' => 'required|string',
      'jenis_kelamin' => 'required|max:1',
      'alamat' => 'required|string',
      'id_kelas' => 'required'
    ]);

    if($validation->fails()){
      $errors = $validation->errors();
      return [
        'status' => 'error',
        'message' => $errors,
        'result' => null
      ];
    }

    $siswa = \App\Siswa::find($id);
    if(empty($siswa)){
      return [
        'status' => 'error',
        'message' => 'Data tidak ditemukan',
        'result' => null
      ];
    }

    $result = $siswa->update($request->all());
    if($result){
      return [
        'status' => 'success',
        'message' => 'Data berhasil diubah',
        'result' => $result
      ];
    }else{
      return [
        'status' => 'error',
        'message' => 'Data gagal diubah',
        'result' => null
      ];
    }
  }

  public function delete(Request $request, $id)
  {
    $siswa = \App\Siswa::find($id);
    if(empty($siswa)){
      return [
        'status' => 'error',
        'message' => 'Data tidak ditemukan',
        'result' => null
      ];
    }

    $result = $siswa->delete($id);
    if($result){
      return [
        'status' => 'success',
        'message' => 'Data berhasil dihapus',
        'result' => $result
      ];
    }else{
      return [
        'status' => 'error',
        'message' => 'Data gagal dihapus',
        'result' => null
      ];
    }
  }

  public function detail($id) {
    $siswa = Siswa::find($id);

    if(empty($siswa)) {
      return [
        'status' => 'error',
        'message' => 'Data tidak ditemukan',
        'result' => null
      ];
    }

    return [
      'status' => 'success',
      'result' => $siswa
    ];

  }

  public function count(){
    $data['siswa'] = count(Siswa::all());
    $data['kelas'] = count(Kelas::all());

    return [
      'status' => 'success',
      'result' => $data
    ];
  }

}
