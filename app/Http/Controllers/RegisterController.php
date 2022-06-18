<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use  App\Models\UserPengguna;
use App\Helper;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class RegisterController extends Controller
{
    public function register_perorangan(Request $request)
    {
        try {
            $required_params = [];
            if (!$request->nama) $required_params[] = 'nama';
            if (!$request->email) $required_params[] = 'email';
            if (!$request->alamat) $required_params[] = 'alamat';
            if (!$request->telepon) $required_params[] = 'telepon';
            if (!$request->password) $required_params[] = 'password';
            if (!$request->jabatan) $required_params[] = 'jabatan';
            if (!$request->pendidikan) $required_params[] = 'pendidikan';
            if (!$request->pekerjaan) $required_params[] = 'pekerjaan';
            if (!$request->perolehan_pelayanan) $required_params[] = 'Perolehan Pelayanan';
            if (!$request->jenis_kelamin) $required_params[] = 'Jenis Kelamin';
            if (!$request->npwp) $required_params[] = 'NPWP';
            if (!$request->nik) $required_params[] = 'NIK';
            if (is_countable($required_params) && count($required_params)){
                $message = "Parameter berikut harus diisi: " . implode(", ", $required_params);
                return Helper::responseFreeCustom(EC::INSUF_PARAM, $message, array());
            }
            $result = UserPengguna::RegisterPerorangan($request);
            if ($result ==  false){
                $message = "Email Sudah Terdaftar";
                return Helper::responseFreeCustom(EC::DATA_NOT_FOUND, $message, array());
            }
            return Helper::responseData($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function register_instansi(Request $request)
    {
        try {
            $required_params = [];
            if (!$request->nama) $required_params[] = 'nama';
            if (!$request->email) $required_params[] = 'email';
            if (!$request->alamat_instansi) $required_params[] = 'Alamat Instansi';
            if (!$request->telepon) $required_params[] = 'telepon';
            if (!$request->password) $required_params[] = 'password';
            if (!$request->jabatan) $required_params[] = 'jabatan';
            if (!$request->pendidikan) $required_params[] = 'pendidikan';
            if (!$request->pekerjaan) $required_params[] = 'pekerjaan';
            if (!$request->perolehan_pelayanan) $required_params[] = 'Perolehan Pelayanan';
            if (!$request->jenis_kelamin) $required_params[] = 'Jenis Kelamin';
            if (!$request->jenis_instansi) $required_params[] = 'Jenis Instansi';
            if (!$request->instansi) $required_params[] = 'Instansi';
            if (!$request->direktorat) $required_params[] = 'Direktorat';
            if (!$request->npwp) $required_params[] = 'NPWP';
            if (is_countable($required_params) && count($required_params)){
                $message = "Parameter berikut harus diisi: " . implode(", ", $required_params);
                return Helper::responseFreeCustom(EC::INSUF_PARAM, $message, array());
            }
            $result = UserPengguna::RegisterInstansi($request);
            if ($result ==  false){
                $message = "Email Sudah Terdaftar";
                return Helper::responseFreeCustom(EC::DATA_NOT_FOUND, $message, array());
            }
            return Helper::responseData($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}