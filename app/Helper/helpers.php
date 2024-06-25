<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Changelog;
use App\Models\Packingslip;

// $ip = $_SERVER['REMOTE_ADDR'];

// send mail helper
function SendMail($data)
{
    // mail log
    $newMail = new \App\Models\MailLog();
    $newMail->from = 'onenesstechsolution@gmail.com';
    $newMail->to = $data['email'];
    $newMail->subject = $data['subject'];
    $newMail->blade_file = $data['blade_file'];
    $newMail->payload = json_encode($data);
    $newMail->save();

    // send mail
    Mail::send($data['blade_file'], $data, function ($message) use ($data) {
        $message->to($data['email'], $data['name'])->subject($data['subject'])->from('onenesstechsolution@gmail.com', env('APP_NAME'));
    });
}

// multi-dimensional in_array
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) return true;
    }
    return false;
}

function groupConcatNames($tableName,$columnName,array $array){
    // echo 'Hi'; exit;
    $data = DB::table($tableName)->selectRaw("GROUP_CONCAT(".$columnName.") AS names")->whereIn('id', $array)->get();

    return str_replace(","," , ",$data[0]->names);
    //  $data[0]->names;
}

function productUnit($product_id)
{
    $product = \App\Models\Product::find($product_id);
    return $product->unit_value.' '.$product->unit_type.' ('.$product->weight_value.' '.$product->weight_type.')';
}

function getProductIdFromBarcode($barcode_no)
{
    $data = DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->first();
    $product_id = !empty($data)?$data->product_id:0;
    return $product_id;
}


function getRandString($n=10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}

function checkStockPO($product_id,$qty){
    $checkStock = DB::table('stock_boxes')->where('is_scanned',0)->where('product_id',$product_id)->count();
    
    if(!empty($checkStock)){
        
        $pieces = DB::table('stock_boxes')->where('is_scanned',0)->where('product_id',$product_id)->sum('pcs');
        return array('status'=>'In Stock','stock'=>$checkStock,'pieces'=>$pieces,'is_stock'=>1);
        // echo 'In stock';
        
    }else{
        
        return array('status'=>'Out of Stock','pieces'=>0,'stock'=>0,'is_stock'=>0);
    }
    
}

function barcodeGen()
{
    $length = 12;    
    $min = str_repeat(0, $length-1) . 1;
    $max = str_repeat(9, $length);
    $barcode_no =  mt_rand($min, $max);   

    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();

    $code_html = $generator->getBarcode($barcode_no, $generator::TYPE_CODE_128);

    $code_base64_img = base64_encode($generatorPNG->getBarcode($barcode_no, $generatorPNG::TYPE_CODE_128));

    return array('barcode_no'=>$barcode_no,'code_html'=>$code_html,'code_base64_img'=>$code_base64_img);

    
}

function getBarcodeDetails($barcode_no)
{
    $data = DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->first();
    return array(
        'code_html'=>$data->code_html,
        'code_base64_img'=>$data->code_base64_img,
        'po_weight_val'=>$data->po_weight_val,
        'scanned_weight_val'=>$data->scanned_weight_val,
        'pcs'=>$data->pcs,
        'product_id'=>$data->product_id
    );
}

function getBarcodeDetailsStock($barcode_no)
{
    $data = DB::table('stock_boxes')->where('barcode_no',$barcode_no)->first();
    return array('code_html'=>$data->code_html,'code_base64_img'=>$data->code_base64_img,'stock_in_weight_val'=>$data->stock_in_weight_val,'stock_out_weight_val'=>$data->stock_out_weight_val,'pcs'=>$data->pcs);
}

function getOrderProductDetails($order_id=0,$product_id=0){
    if(!empty($order_id) && !empty($product_id)){
        $data = DB::table('order_products')->where('order_id',$order_id)->where('product_id',$product_id)->first();

        return $data;
    }
}

function getAmountAlphabetically($amount)
{
    $number = $amount;
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ? "" . $words[$point / 10] . " " . $words[$point = $point % 10] : 'Zero';
    return  ucwords($result) . " Rupees  and " . $points . " Paise";
}

function getOrderDetails($order_id)
{
    $order = DB::table('orders')->find($order_id);
    return $order;
}

function getPercentageVal($percent,$number)
{
    return ($percent / 100) * $number;
}

function getMonthName()
{
    $months = array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November',  '12'=>'December' );

    return $months;
    
}

function GetDrivingDistance($lat1, $lon1, $lat2, $lon2){
    // $oldKey = "AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I";
    // $key = "AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";
    $app_settings = DB::table('app_settings')->find(1);
    $google_api_key = $app_settings->google_api_key;

    if($lat2!=0 && $lon2!=0){
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $lon1 . "&destinations=" . $lat2 . "," . $lon2 . "&mode=driving&key=".$google_api_key;
           
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        //echo $response;
        curl_close($ch);
        $response_a = json_decode($response, true);

        // return $response_a;

        if(!empty($response_a['rows'])){
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];

            // return $dist;
            $distance_value = $response_a['rows'][0]['elements'][0]['distance']['value'];

            $total_time = $response_a['rows'][0]['elements'][0]['duration']['value'];

            $time = $total_time / 60;

            return array('distance' => $dist, 'distance_value' => $distance_value , 'time' => $time);
        }else{
            return array('distance' => '0', 'distance_value' => '0', 'time' => '0');
        }

    }else{
        return array('distance' => '0', 'distance_value' => '0',  'time' => '0');
    }
}


function GetDrivingDistanceTest($lat1, $lon1, $lat2, $lon2){
    $oldKey = "AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I";
    $key = "AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";
    $app_settings = DB::table('app_settings')->find(1);
    $google_api_key = $app_settings->google_api_key;
    // $abhinavKey = "AIzaSyAkwlSsaYwOB0T79ZgKI7_vgQNbRxzD1xc";
    if($lat2!=0 && $lon2!=0){
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $lon1 . "&destinations=" . $lat2 . "," . $lon2 . "&mode=driving&key=".$google_api_key;
           
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        //echo $response;
        curl_close($ch);
        $response_a = json_decode($response, true);

        return $response_a;
        if(!empty($response_a['rows'])){
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];

            // return $dist;
            $distance_value = $response_a['rows'][0]['elements'][0]['distance']['value'];

            $total_time = $response_a['rows'][0]['elements'][0]['duration']['value'];

            $time = $total_time / 60;

            return array('distance' => $dist, 'distance_value' => $distance_value , 'time' => $time);
        }else{
            return array('distance' => '0', 'distance_value' => '0', 'time' => '0');
        }

        
    }else{
        return array('distance' => '0',  'distance_value' => '0', 'time' => '0');
    }
}

function updateProductSellPrice($price,$cost_price,$product_id)
{
    $app_settings = DB::table('app_settings')->find(1);
    $product_sales_price_threshold_percentage = $app_settings->product_sales_price_threshold_percentage;

    $product_threshold_sell_price = getPercentageVal($product_sales_price_threshold_percentage,$cost_price);
    $new_sell_price = ($cost_price + $product_threshold_sell_price);
    DB::table('products')->where('id',$product_id)->update([
        'threshold_price' => $price,
        'product_sales_price_threshold_percentage' => $product_sales_price_threshold_percentage,
        'sell_price' => $new_sell_price,
        'cost_price' => $cost_price
    ]);
}

function getCrDr($amount)
{
    if($amount > 0){
        return "Cr"; # if postive +
    } else if($amount < 0) {
        return "Dr"; # if negative -
    } else {
        return "";
    }
}

function replaceMinusSign($number)
{
    return str_replace("-","",$number);
}

function psProductPcsFromCtn($slip_no,$product_id){
    $packing_slip_boxes = DB::table('packing_slip_boxes')->where('slip_no',$slip_no)->where('product_id',$product_id)->first();
   
    return $packing_slip_boxes->pcs ;
}

function get_product_ctns_pcs_ps($order_id,$product_id)
{
    $barcodes = array();
    $barcode_nos = "";
    $no_of_ctns = DB::table('set_product_ctns_pcs_ps')->where('order_id',$order_id)->where('product_id',$product_id)->count();
    $total_pcs = DB::table('set_product_ctns_pcs_ps')->where('order_id',$order_id)->where('product_id',$product_id)->sum('pcs');
    $product_ctns_pcs_ps = DB::table('set_product_ctns_pcs_ps')->where('order_id',$order_id)->where('product_id',$product_id)->get();
    if(!empty($product_ctns_pcs_ps)){
        foreach($product_ctns_pcs_ps as $barcode){
            $barcodes[] = $barcode->barcode_no;
        }
    }

    if(!empty($barcodes)){
        $barcode_nos = implode(",",$barcodes);
    }

    return array('no_of_ctns'=>$no_of_ctns,'total_pcs'=>$total_pcs,'barcode_nos'=>$barcode_nos);
}

function getDaysFromDateRange($start, $end, $format = 'Y-m-d') {
    
    $earlier = new DateTime(date('Y-m-d', strtotime($start)));
    $later = new DateTime(date('Y-m-d', strtotime($end)));
    // echo $start;
    // echo $end;
    $diff = $earlier->diff($later);
    // echo $diff->days; 
    return $diff->days;

}

function getGSTAmount($cost_price,$gst_val){
    $gst_amount = $cost_price - ( $cost_price * ( 100 / ( 100 + (getPercentageVal($gst_val,100)) ) ) );
    $net_price = ($cost_price - $gst_amount);

    return array('gst_amount' => $gst_amount , 'net_price' => $net_price);
}

function userAccesses($designation_id,$role_id){
    $data = DB::table('user_roles')->where('designation_id',$designation_id)->where('role_id',$role_id)->first();

    if(!empty($data)){
        return true;
    } else {
        return false;
    }
}

function getSingleAttributeTable($tableName,$id,$field){
    $data = DB::table($tableName)->select($field)->where('id',$id)->first();
    return !empty($data)?$data->$field:'';
}


function isBulkScanned($purchase_order_id,$product_id){
    $data = DB::table('purchase_order_boxes')->where('purchase_order_id',$purchase_order_id)->where('product_id',$product_id)->where('is_bulk_scanned', 1)->first();

    if(!empty($data)){
        return true;
    } else {
        return false;
    }
}

function genAutoIncreNoInv($length=10,$table='invoice',$type='g'){
    $val = 1;    
    $data = DB::table($table)->select('id')->orderBy('id','desc')->first();
    if(empty($data)){
        $val = 1;
    } else {
        $val = $data->id + 1;
    }
    
    $number = str_pad($val,$length,"0",STR_PAD_LEFT);
    return $number;
}

function updatelocationattendance($attendance_id,$latitude,$longitude,$store_id){

    $attendance_locations_last = DB::table('attendance_locations')->where('attendance_id',$attendance_id)->orderBy('id','desc')->first();

    $latitude1 = $attendance_locations_last->latitude;
    $longitude1 = $attendance_locations_last->longitude;
    $mac_id = $attendance_locations_last->mac_id;
    $user_id = $attendance_locations_last->user_id;

    $latitude2 = $latitude;
    $longitude2 = $longitude;

    $GetDrivingDistance = GetDrivingDistance($latitude1,$longitude1,$latitude2,$longitude2);

    $distance = $GetDrivingDistance['distance'];
    $distance_value = $GetDrivingDistance['distance_value'];

    DB::table('attendance_locations')->insert([
        'user_id' => $user_id,
        'attendance_id' => $attendance_id,
        'latitude' => $latitude2,
        'longitude' => $longitude2,
        'store_id' => $store_id,
        'mac_id' => $mac_id,
        'distance' => $distance,
        'distance_value' => $distance_value,
        'entry_date' => date('Y-m-d'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    $sum_distance_val = DB::table('attendance_locations')->where('attendance_id',$attendance_id)->sum('distance_value');
    $sum_distance_text = $sum_distance_val / 1000 .' km';

    DB::table('user_attendances')->where('id', $attendance_id)->update([
        'end_date' => date('Y-m-d'),
        'end_time' => date('H:i'),
        'end_latitude' => $latitude2,
        'end_longitude' => $longitude2,
        'total_distance' => $sum_distance_val,
        'total_distance_text' => $sum_distance_text,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
}

function getPODetails($id,$product_id){
    $data = DB::table('purchase_order_products')->where('purchase_order_id',$id)->where('product_id',$product_id)->first();

    return $data;
}

function getCountPOGRN($id,$product_id){
    $data = DB::table('purchase_order_boxes')->where('purchase_order_id',$id)->where('product_id',$product_id)->where('is_scanned', 1)->where('is_archived', 0)->count();

    return $data;
}

function genAutoIncreNoBarcode($product_id,$year){
    $val = 1;    
    $data = DB::table('purchase_order_boxes')->where('product_id',$product_id)->whereRaw("DATE_FORMAT(created_at, '%Y') = '".$year."'")->count();

    if(!empty($data)){
        $val = ($data + 1);
    }

    // dd($data);
    $prefix = $product_id.''.$year.'';
    $suffix = str_pad($val,7,"0",STR_PAD_LEFT);
    $number = $prefix.''.$suffix;
    $barcode_no = $number;
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();

    $code_html = $generator->getBarcode($barcode_no, $generator::TYPE_CODE_128);

    $code_base64_img = base64_encode($generatorPNG->getBarcode($barcode_no, $generatorPNG::TYPE_CODE_128));

    return array('barcode_no'=>$barcode_no,'code_html'=>$code_html,'code_base64_img'=>$code_base64_img);
    
}

function changelogentry($doneby,$purpose,$data_details){    
    $insertData = array(
        'doneby' => $doneby,
        'purpose' => $purpose,
        'data_details' => $data_details,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    );
    Changelog::insert($insertData);
}

function get_packing_slip($slip_no,$product_id){
    $data = Packingslip::where('slip_no',$slip_no)->where('product_id',$product_id)->first();
    return $data;
}
