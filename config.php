<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['HTTP_HOST'] == "localhost") {
    $con = mysqli_connect("localhost", "root", "root", "avmgodrej_mlm_db");
    $URLS = "http://localhost/mlm"; 
    define(BASEDIR, $_SERVER['DOCUMENT_ROOT']."/mlm");
}
else {    
    $con=mysqli_connect("localhost","avmgodrej_mlm_user","R3CMM-5#m(#O","avmgodrej_mlm_db") or die ('Limit Exceed'); 
    $URLS="https://avmgodrej.com/mlm";
    define(BASEDIR, $_SERVER['DOCUMENT_ROOT']);
}

function Get_Count_AllData($con,$table){
    $query=mysqli_query($con,"select count(id) as countss from $table");
    $row=mysqli_fetch_array($query);    
    return $row['countss']; 
}
function Get_Count_Data($con,$id,$fields,$table){
    //echo "select count(id) as countss from $table where $fields='".$id."'";
    $query=mysqli_query($con,"select count(id) as countss from $table where $fields='".$id."'");
    $row=mysqli_fetch_array($query);	
    return $row['countss'];	
}
function Get_Count_TwoData($con,$id,$fields,$id1,$fields1,$table){
    $query=mysqli_query($con,"select count(id) as countss from $table where $fields='".$id."' and $fields1='".$id1."'");
    $row=mysqli_fetch_array($query);    
    return $row['countss']; 
}
function Get_Fetch_Data($con,$id,$parameter,$table){
    if($parameter=='All'){ $data="*"; } else { $data=$parameter; }
    $query=mysqli_query($con,"select $data from $table where id='".$id."'");
    $row=mysqli_fetch_array($query);	
    return $row;	
}

function Get_Fetch_Fields($con,$field,$id,$parameter,$table){
    if($parameter=='All'){ $data="*"; } else { $data=$parameter; }
    $query=mysqli_query($con,"select $data from $table where $field='".$id."'");
    $row=mysqli_fetch_array($query);    
    return $row;    
}

function MemberCode($con){
    $sql=mysqli_query($con,"select max(right(MemberCode,4)) as mcode from members_details"); 
    $row=mysqli_fetch_array($sql);
    if($row['mcode']!=''){
    $orderid=$row['mcode'];
    $Number=$orderid+1; 
    } else { $Number="001"; }
    $CustID = "S".sprintf('%04d',$Number);
    return $CustID;
}

function ProductCode($con){
    $sql=mysqli_query($con,"select max(right(ProductCode,4)) as mcode from product_details"); 
    $row=mysqli_fetch_array($sql);
    if($row['mcode']!=''){
    $orderid=$row['mcode'];
    $Number=$orderid+1; 
    } else { $Number="001"; }
    $CustID = "MIP".sprintf('%04d',$Number);
    return $CustID;
}

function imageResize($imageResourceId,$width,$height) {
    $dimetions=calculateDimensions($width,$height,1000,1000);
    $targetWidth =$dimetions['width'];
    $targetHeight =$dimetions['height'];	
    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    return $targetLayer;
}
function calculateDimensions($width,$height,$maxwidth,$maxheight){

    if($width != $height)
    {
        if($width > $height)
        {
            $t_width = $maxwidth;
            $t_height = (($t_width * $height)/$width);
            //fix height
            if($t_height > $maxheight)
            {
                $t_height = $maxheight;
                $t_width = (($width * $t_height)/$height);
            }
        }
        else
        {
            $t_height = $maxheight;
            $t_width = (($width * $t_height)/$height);
            //fix width
            if($t_width > $maxwidth)
            {
                $t_width = $maxwidth;
                $t_height = (($t_width * $height)/$width);
            }
        }
    }
    else
        $t_width = $t_height = min($maxheight,$maxwidth);

    return array('height'=>(int)$t_height,'width'=>(int)$t_width);
}

function Amount_Format($amount){
    $result = str_split($amount);
    foreach($result as $key => $value) {
         $a=array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","0"=>"0");
        if(1==array_search($value,$a)){
          $mrp .="B";  
        }elseif(2==array_search($value,$a)){
        $mrp .="L";  
        }elseif(3==array_search($value,$a)){
         $mrp .="A";    
        }elseif(4==array_search($value,$a)){
          $mrp .="C";      
        }
        elseif(5==array_search($value,$a)){
          $mrp .="K";      
        }
        elseif(6==array_search($value,$a)){
          $mrp .="W";      
        }
        elseif(7==array_search($value,$a)){
          $mrp .="H";      
        }
        elseif(8==array_search($value,$a)){
          $mrp .="I";      
        }
        elseif(9==array_search($value,$a)){
          $mrp .="T";      
        }
        elseif(0==array_search($value,$a)){
          $mrp .="E";      
        }
    }
    //echo $mrp;
    return $mrp;
}


function Get_City_Details($con,$city){
    $query=mysqli_query($con,"SELECT id,city_name FROM `city_details` WHERE `city_name` LIKE '".$city."'");
    $row=mysqli_fetch_array($query);
    return $row['id']; 	
}
function convert_number($number) { 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $ln = floor($number / 100000);     /* Thousands (kilo) */ 
    $number -= $ln * 100000; 
	 $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 
    if ($ln) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($ln) . " Lakh"; 
    } 
    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
}

function calculateFiscalYearForDate($month){
    if($month > 4){
    $y = date('Y');
    $pt = date('Y', strtotime('+1 year'));
    $fy = $y."-04-01".":".$pt."-03-31";
    }else{
    $y = date('Y', strtotime('-1 year'));
    $pt = date('Y');
    $fy = $y."-04-01".":".$pt."-03-31";
    }
    return $fy;
}

function financialyears($month){
    //$month =date('m');
    if ($month >= '01' && $month < '03'){
    $fyears= date("Y")-1;
    }else{
    $fyears= date("Y"); 
    }
    return $fyears;
}

function Get_Role_Features($con,$rid,$Menus,$fields){    
    $sql=mysqli_query($con,"select $fields from role_permission where role_details_id='".$rid."' and menus='".$Menus."'");
    $row=mysqli_fetch_array($sql);
    return $row["$fields"]; 
}
function verifyIFSC($ifsc_code) {
    $url = 'https://ifsc.razorpay.com/' . $ifsc_code;
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    if ($result && isset($result['BRANCH'])) {
        return $result;
    } else {
        return false;
    }
}
?>