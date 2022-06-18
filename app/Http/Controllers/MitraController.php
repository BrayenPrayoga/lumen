<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper;
use App\Models\PembayaranSimponi;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class MitraController extends Controller
{
    public function pembayaran_simponi(Request $request) {
        try {
            $data = $request->all();
            if(is_countable($data) && count($data) < 1){
                return Helper::responseFreeCustom(EC::DATA_NOT_FOUND, EM::DATA_NOT_FOUND, array());
            }

            $result = PembayaranSimponi::Pembayaran($data);
            return Helper::responseData($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}