<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;
use Illuminate\Support\Facades\Hash;
use App\Helper;

class UserPengguna extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users_pengguna';
    
    protected $guarded = [];
    // protected $fillable = [
    //     'name', 'email',
    // ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password','id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    static function RegisterPerorangan($param)
    {
        try {
            $user = UserPengguna::where('email', $param->email)->first();
            $datenow = date('Y-m-d H:i:s');
            if($user){
                return false;
            }
            $data = UserPengguna::create([
                'nama'              => $param->nama,
                'email'             => $param->email,
                'alamat'            => $param->alamat,
                'no_telp'           => $param->telepon,
                'password'          => Hash::make($param->password),
                'jenis_pengguna'    => '1',
                'jabatan'           => $param->jabatan,
                'pendidikan'        => $param->pendidikan,
                'pekerjaan'         => $param->pekerjaan,
                'perolehan_pelayanan' => $param->perolehan_pelayanan,
                'jenis_kelamin'     => $param->jenis_kelamin,
                'aktifasi'          => true,
                'npwp'              => $param->npwp,
                'nik'               => $param->nik,
                'created_at'        => $datenow,
                'updated_at'        => null,
            ]);
            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static function RegisterInstansi($param)
    {
        try {
            $user = UserPengguna::where('email', $param->email)->first();
            $datenow = date('Y-m-d H:i:s');
            if($user){
                return false;
            }
            $data = UserPengguna::create([
                'nama'              => $param->nama,
                'email'             => $param->email,
                'alamat_instansi'   => $param->alamat_instansi,
                'no_telp'           => $param->telepon,
                'password'          => Hash::make($param->password),
                'jenis_pengguna'    => '2',
                'jabatan'           => $param->jabatan,
                'pendidikan'        => $param->pendidikan,
                'pekerjaan'         => $param->pekerjaan,
                'perolehan_pelayanan' => $param->perolehan_pelayanan,
                'jenis_kelamin'     => $param->jenis_kelamin,
                'aktifasi'          => true,
                'jenis_instansi'    => $param->jenis_instansi,
                'instansi'          => $param->instansi,
                'direktorat'        => $param->direktorat,
                'npwp'              => $param->npwp,
                'created_at'        => $datenow,
                'updated_at'        => null,
            ]);
            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
