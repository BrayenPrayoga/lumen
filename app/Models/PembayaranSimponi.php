<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Helper;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class PembayaranSimponi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'NTPN';
    protected $table = 'data_pembayaran_simponi';
    protected $fillable = [
        'usr_id_SIMPONI','trx_id_SIMPONI','kode_billing_SIMPONI','NTPN','NTB','tgl_jam_pembayaran','bank_persepsi','channel_pembayaran','tgl_buku','status'
    ];

    static function Pembayaran($request)
    {
        try {
            date_default_timezone_set("Asia/Bangkok");

            foreach($request as $key=>$param){
                $array_ntpn[] = $param['NTPN'];
                $pembayaran = PembayaranSimponi::where('NTPN', $param['NTPN'])->first();
                $datenow = date('Y-m-d H:i:s');
                if (empty($pembayaran)){
                        $data = [
                            'usr_id_SIMPONI'         => $param['usr_id_SIMPONI'],
                            'trx_id_SIMPONI'         => $param['trx_id_SIMPONI'],
                            'kode_billing_SIMPONI'   => $param['kode_billing_SIMPONI'],
                            'NTPN'                   => $param['NTPN'],
                            'NTB'                    => $param['NTB'],
                            'tgl_jam_pembayaran'     => $param['tgl_jam_pembayaran'],
                            'bank_persepsi'          => $param['bank_persepsi'],
                            'channel_pembayaran'     => $param['channel_pembayaran'],
                            'tgl_buku'               => $param['tgl_buku'],
                            'status'                 => 3,
                        ];
                        PembayaranSimponi::create($data);
                }else{
                    PembayaranSimponi::where('NTPN', $param['NTPN'])->update(['status'=>2]);
                }
            }
            
            $dataPembayaran = PembayaranSimponi::whereIn('NTPN', $array_ntpn)->get();
            foreach($dataPembayaran as $val){
                $response[] = [
                    'usr_id_SIMPONI'         => $val->usr_id_SIMPONI,
                    'trx_id_SIMPONI'         => $val->trx_id_SIMPONI,
                    'kode_billing_SIMPONI'   => $val->kode_billing_SIMPONI,
                    'NTPN'                   => $val->NTPN,
                    'NTB'                    => $val->NTB,
                    'tgl_jam_pembayaran'     => $val->tgl_jam_pembayaran,
                    'bank_persepsi'          => $val->bank_persepsi,
                    'channel_pembayaran'     => $val->channel_pembayaran,
                    'tgl_buku'               => $val->tgl_buku,
                    'status'                 => $val->status,
                    'message'                => ($val->status == 2) ? 'Pembayaran Sudah Pernah Dikirimkan' : 'Pembayaran Diterima'
                ];
            }
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
