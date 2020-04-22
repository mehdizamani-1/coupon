<?php

namespace App\Http\Controllers;

use App\Depot_Logs;
use App\Owners_Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function pointInPolygon($lat_lng, $coordinates,  $delimiter = '|')
    {
        /** Remove Space From Strings  */
        $positions = str_replace(" ", "", $coordinates);
        $lat_lng = str_replace(" ", "", $lat_lng);


        $lat = explode(",", $lat_lng)[0];
        $lng = explode(",", $lat_lng)[1];


        /* Single Polygon */
        if (strpos($positions, '+') <= 0) {
            $positions = explode($delimiter, $positions);
            $result = false;
            $j = count($positions) - 1;
            $last_position = explode(',', $positions[$j]);
            for ($i = 0; $i < count($positions); $i++) {
                $this_position = explode(',', $positions[$i]);
                if( isset($last_position[1])){
                    if (count($this_position) == 2)
                        if (
                            ((($this_position[1] <= $lng) && ($lng < $last_position[1])) || (($last_position[1] <= $lng) && ($lng < $this_position[1]))) &&
                            ($lat < (($last_position[0] - $this_position[0]) * ($lng - $this_position[1]) / ($last_position[1] - $this_position[1]) + $this_position[0]))
                        ) $result = !$result;
                }

                $j = $i;
                $last_position = explode(',', $positions[$j]);
            }

            if ($result == true)
                return 1;
            else
                return 0;
        } else {
            /* Multi Polygon */
            $positions_arr = explode('+', $positions);
            for ($psx = 0; $psx < count($positions_arr); $psx++) {
                $positions = $positions_arr[$psx];
                $positions = explode($delimiter, $positions);
                $result = false;
                $j = count($positions) - 1;
                $last_position = explode(',', $positions[$j]);
                for ($i = 0; $i < count($positions); $i++) {
                    $this_position = explode(',', $positions[$i]);
                    if (
                        ((($this_position[1] <= $lng) && ($lng < $last_position[1])) || (($last_position[1] <= $lng) && ($lng < $this_position[1]))) &&
                        ($lat < (($last_position[0] - $this_position[0]) * ($lng - $this_position[1]) / ($last_position[1] - $this_position[1]) + $this_position[0]))
                    ) $result = !$result;
                    $j = $i;
                    $last_position = explode(',', $positions[$j]);
                }

                if ($result == true)
                    return 1;
            }
            return 0;

        }
    }
    protected function respondWithToken($token, $user = NULL)
    {
        if( $user == NULL)
            return response()->json([
                'access_token' => $token,
                'token_type' => 'WebService',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'status_number' => 1,
                'status' => 'ok',
            ]);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'WebService',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'status_number' => 1,
            'status' => 'ok',
            'user' => $user,
        ]);

    }
    protected function GetMeURL()
    {
        return \Config::get('app.url');
    }
    protected function createLog($params = array()){
        $log = new Owners_Log();

        foreach ($params as $key=>$param ){
            $log->$key = $param;
        }
        if( $log->save() ){
            return true;
        }else{
            return false;
        }
    }

    protected function SetHeader(){
        header("Access-Control-Allow-Origin: *");
    }
    protected function convertPersianNumbersToEnglish($number)
    {
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        return str_replace($persian, $num, $number);
    }
    public function jalali_to_gregorian($jy, $jm, $jd, $mod = '')
    {
        $jy = $this->convertPersianNumbersToEnglish($jy);
        $jm = $this->convertPersianNumbersToEnglish($jm);
        $jd = $this->convertPersianNumbersToEnglish($jd);
//        list($jy,$jm,$jd)=explode('_',tr_num($jy.'_'.$jm.'_'.$jd));/* <= Extra :اين سطر ، جزء تابع اصلي نيست */
        if ($jy > 979) {
            $gy = 1600;
            $jy -= 979;
        } else {
            $gy = 621;
        }
        $days = (365 * $jy) + (((int)($jy / 33)) * 8) + ((int)((($jy % 33) + 3) / 4)) + 78 + $jd + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
        $gy += 400 * ((int)($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int)(--$days / 36524));
            $days %= 36524;
            if ($days >= 365) $days++;
        }
        $gy += 4 * ((int)(($days) / 1461));
        $days %= 1461;
        $gy += (int)(($days - 1) / 365);
        if ($days > 365) $days = ($days - 1) % 365;
        $gd = $days + 1;
        foreach (array(0, 31, ((($gy % 4 == 0) and ($gy % 100 != 0)) or ($gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v) break;
            $gd -= $v;
        }
        return ($mod === '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }
    public function base64ToImage($base64_string, $output_file, $ext = 'jpg') {
        $file = fopen($output_file, "wb");

        $data = explode(',', $base64_string);
        $image = base64_decode($data[1]);
        $Ext = pathinfo($image, PATHINFO_EXTENSION);
        fwrite($file, $image);
        fclose($file);
        return $output_file;
//        if( $Ext == $ext ){
//            fwrite($file, $image);
//            fclose($file);
//            return $output_file;
//
//        }else{
//            return NULL;
//        }



    }
    protected function whoIs($guard = 'api'){
        $this->middleware('auth:api');
        return auth()->guard($guard)->user();

    }
    public function gregorian_to_jalali($gy,$gm,$gd,$mod=''){
        $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);
        if($gy>1600){
            $jy=979;
            $gy-=1600;
        }else{
            $jy=0;
            $gy-=621;
        }
        $gy2=($gm>2)?($gy+1):$gy;
        $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
        $jy+=33*((int)($days/12053));
        $days%=12053;
        $jy+=4*((int)($days/1461));
        $days%=1461;
        if($days > 365){
            $jy+=(int)(($days-1)/365);
            $days=($days-1)%365;
        }
        $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
        $jd=1+(($days < 186)?($days%31):(($days-186)%30));
        return($mod=='')?array($jy,$jm,$jd):$jd.$mod.$jm.$mod.$jy;
    }
    protected function  manhattan($coordinate_1, $coordinate_2){
        // distance between latitudes
        // and longitudes
        $coordinate_1 = str_replace(" ", "", $coordinate_1);
        $coordinate_2 = str_replace(" ", "", $coordinate_2);
        $lt_lng_1_array = explode(',', $coordinate_1);
        $lt_lng_2_array = explode(',', $coordinate_2);
        $lat1 = $lt_lng_1_array[0];
        $lon1 = $lt_lng_1_array[1];
        $lat2 = $lt_lng_2_array[0];
        $lon2 = $lt_lng_2_array[1];

        $dLat = ($lat2 - $lat1) *
            M_PI / 180.0;
        $dLon = ($lon2 - $lon1) *
            M_PI / 180.0;

        // convert to radians
        $lat1 = ($lat1) * M_PI / 180.0;
        $lat2 = ($lat2) * M_PI / 180.0;

        // apply formulae
        $a = pow(sin($dLat / 2), 2) +
            pow(sin($dLon / 2), 2) *
            cos($lat1) * cos($lat2);
        $rad = 6371;
        $c = 2 * asin(sqrt($a));
        return $rad * $c;
    }

}
