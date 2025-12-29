<?php

use Akaunting\Money\Money;

/**
     * Date formatter indonesia
     */

     function dateid($format, $time = false) { // "Asia/Tokyo"
        $day   = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min');
        $days  = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
        $month = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov' ,'Des');
        $months= array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November' ,'Desember');
        
        if(!is_a($time, 'DateTime')) {
            if(is_int($time)) {
                $time = new DateTime(date('Y-m-d H:i:s.u',$time));
            }elseif(is_string($time)){
                try {
                    $time = new DateTime($time);
                } catch (Exception $e) {
                    $time = new DateTime();
                }
            }else{
                $time = new DateTime();
            }
        }
        $ret = '';
        for($i=0;$i<strlen($format);$i++) {
            switch($format[$i]) {
                case 'D' : $ret .= $day[ $time->format('w') ]; break;
                case 'l' : $ret .= $days[ $time->format('w') ]; break;
                case 'M' : $ret .= $month[ $time->format('n') ]; break;
                case 'F' : $ret .= $months[ $time->format('n') ]; break;
                case '\\': $ret .= $format[ $i+1 ]; $i++; break;
                default  : $ret .= $time->format( $format[$i] ); break;
            }
        }
        return $ret;
    }
    
     /**
     * Money formatter IDR
     */

     function rupiah($money){
        return Money::IDR($money,true);
    }

    /**
     * fonnte send message function
     *
     * @param [type] $token
     * @param [type] $data
     * @return void
     */

    function kirimPesan($token, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $data["target"],
                'message' => $data["message"],
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }