<?php
/**
 * 实物订单行为 v3-b12
 *
 * 好商城 V3 www.shopnc.net
 */
defined('InShopNC') or exit('Access Invalid!');

class numberLogic {
     //密码字典 
    private $dic = array( 
        0=>'0',    1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5', 6=>'6', 7=>'7', 8=>'8',     
        9=>'9', 10=>'A',  11=>'B', 12=>'C', 13=>'D', 14=>'E', 15=>'F',  16=>'G',  17=>'H',     
        18=>'I',19=>'J',  20=>'K', 21=>'L',  22=>'M',  23=>'N', 24=>'O', 25=>'P', 26=>'Q',     
    27=>'R',28=>'S',  29=>'T',  30=>'U', 31=>'V',  32=>'W',  33=>'X', 34=>'Y', 35=>'Z' 
    ); 
        
        /**
         *
         *
         * @param string $hash The password hash to extract info from
         *
         * @return array The array of information about the hash.
         */
        function encodeID($int, $format=8) {
            $dics = $this->dic; 
        $dnum = 36; //进制数 
        $arr = array (); 
        $loop = true; 
        while ($loop) { 
            $arr[] = $dics[bcmod($int, $dnum)]; 
            $int = bcdiv($int, $dnum, 0); 
            if ($int == '0') { 
                $loop = false; 
            } 
        } 
        if (count($arr) < $format) 
            $arr = array_pad($arr, $format, $dics[0]); 
 
        return implode('', array_reverse($arr));
        }
        

}

?>
