<?php
function base64ToImage($base64_string, $output_file, $ext = 'jpg') {
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
function  manhattan($coordinate_1, $coordinate_2){
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
function randomString($len, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $len; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function jalali_to_gregorian($jy, $jm, $jd, $mod = '')
{
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
function gregorian_to_jalali($gy,$gm,$gd,$mod=''){
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
function pointInPolygon($lat_lng, $coordinates,  $delimiter = '|')
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
function getParam(){
    if( isset($_SERVER['QUERY_STRING']) ){
        return htmlentities($_SERVER['QUERY_STRING']);
    }
    return NULL;
}
function gregorian_to_jalali_string($date, $time = false, $mod='/', $type = 1){
    if( $time == true ){

        $array = explode(' ', $date);
        $arr = explode('-', $array[0]);
        if( !isset($arr[1]) )
            return '';
    }else{
        $arr = explode('-', $date);
        if( !isset($arr[1]) )
            return '';
    }
    $gy = $arr[0];
    $gm = $arr[1];
    $gd = $arr[2];
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
    if( $type == 1 ){
        return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;

    }elseif( $type == 2 ){
        $month = '';
        switch ($jm){
            case 1:
                $month = 'فروردین';
                break;
            case 2:
                $month = 'اردیبهشت';
                break;
            case 3:
                $month = 'خرداد';
                break;
            case 4:
                $month = 'تیر';
                break;
            case 5:
                $month = 'مرداد';
                break;
            case 6:
                $month = 'شهریور';
                break;
            case 7:
                $month = 'مهر';
                break;
            case 8:
                $month = 'آبان';
                break;
            case 9:
                $month = 'آذر';
                break;
            case 10:
                $month = 'دی';
                break;
            case 11:
                $month = 'بهمن';
                break;
            case 12:
                $month = 'اسفند';
                break;
        }
        return $jd. ' '. $month . ' ' . $jy;
    }else{
        if( $time == true )
            return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd. ' ' . $array[1];
        else
            return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
    }
}
function gregorian_to_jalali_pro($date, $time = false){
    if( $time == true ){

        $array = explode(' ', $date);
        $arr = explode('-', $array[0]);
        $date_send = $array[0];
        if( !isset($arr[1]) )
            return '';
    }else{
        $arr = explode('-', $date);
        $date_send = $date;
        if( !isset($arr[1]) )
            return '';
    }
    $now_date = date('Y-m-d');
    $now_time = date('H:i:s');
    if( strtotime($date_send) == strtotime($now_date) ){
        if( $time == true ){
            $time_send = $array[1];
            $diff = strtotime($now_time) - strtotime($time_send);
            if( $diff < 60 ){
                return 'لحظاتی پیش';
            }else if( $diff >= 60 &&  $diff < 840  ){
                return 'دقایقی پیش';
            }else if( $diff >= 840 &&  $diff < 1800  ){
                return 'یک رب پیش';
            }else if( $diff >= 1800 && $diff < 3600  ){
                return 'نیم ساعت پیش';
            }else{
                $hour_diff = (integer)($diff / 3600);
                return "$hour_diff"." ساعت پیش ";
            }
        }else{
            return 'امروز';
        }
    }
    elseif( (strtotime($now_date) - strtotime($date_send))/(86400) == 1 ){
        return 'یک روز پیش';
    }elseif( (strtotime($now_date) - strtotime($date_send))/(86400) == 2 ){
        return 'دو روز پیش';
    }else{
        $gy = $arr[0];
        $gm = $arr[1];
        $gd = $arr[2];
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
    }



    $month = '';
    switch ($jm) {
        case 1:
            $month = 'فروردین';
            break;
        case 2:
            $month = 'اردیبهشت';
            break;
        case 3:
            $month = 'خرداد';
            break;
        case 4:
            $month = 'تیر';
            break;
        case 5:
            $month = 'مرداد';
            break;
        case 6:
            $month = 'شهریور';
            break;
        case 7:
            $month = 'مهر';
            break;
        case 8:
            $month = 'آبان';
            break;
        case 9:
            $month = 'آذر';
            break;
        case 10:
            $month = 'دی';
            break;
        case 11:
            $month = 'بهمن';
            break;
        case 12:
            $month = 'اسفند';
            break;
    }
    return $jd. ' '. $month . ' ' . $jy;


}
function curlPost($endpoint, $body, $headers = array())
{
    $headers = array_merge(
        $headers,
        array(
            'Content-Type: application/x-www-form-urlencoded',
        )
    );

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    return json_decode($result, true);
}
function curl_custom_postFields($ch, array $assoc = array(), array $files = array()) {

    // invalid characters for "name" and "filename"
    static $disallow = array("\0", "\"", "\r", "\n");

    // build normal parameters
    foreach ($assoc as $k => $v) {
        $k = str_replace($disallow, "_", $k);
        $body[] = implode("\r\n", array(
            "Content-Disposition: form-data; name=\"{$k}\"",
            "",
            filter_var($v),
        ));
    }

    // build file parameters
    foreach ($files as $k => $v) {
        switch (true) {
            case false === $v = realpath(filter_var($v)):
            case !is_file($v):
            case !is_readable($v):
                continue; // or return false, throw new InvalidArgumentException
        }
        $data = file_get_contents($v);
        $v = call_user_func("end", explode(DIRECTORY_SEPARATOR, $v));
        $k = str_replace($disallow, "_", $k);
        $v = str_replace($disallow, "_", $v);
        $body[] = implode("\r\n", array(
            "Content-Disposition: form-data; name=\"{$k}\"; filename=\"{$v}\"",
            "Content-Type: application/octet-stream",
            "",
            $data,
        ));
    }

    // generate safe boundary
    do {
        $boundary = "---------------------" . md5(mt_rand() . microtime());
    } while (preg_grep("/{$boundary}/", $body));

    // add boundary for each parameters
    array_walk($body, function (&$part) use ($boundary) {
        $part = "--{$boundary}\r\n{$part}";
    });

    // add final boundary
    $body[] = "--{$boundary}--";
    $body[] = "";

    // set options
    return @curl_setopt_array($ch, array(
        CURLOPT_POST       => true,
        CURLOPT_POSTFIELDS => implode("\r\n", $body),
        CURLOPT_HTTPHEADER => array(
            "Expect: 100-continue",
            "Content-Type: multipart/form-data; boundary={$boundary}", // change Content-Type
        ),
    ));
}
function SetHeader(){
    header("Access-Control-Allow-Origin: *");
}
function myPrintR($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    exit;
}
function convertPersianNumbersToEnglish($number)
{
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $number);
}
function convertPersianNumbersToEnglishDate($str)
{
    $numbers = explode('/', $str);
    $english_num = array();
    foreach ($numbers as $number){
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        $english_num[] = str_replace($persian, $num, $number);
    }
    return implode('/', $english_num);

}