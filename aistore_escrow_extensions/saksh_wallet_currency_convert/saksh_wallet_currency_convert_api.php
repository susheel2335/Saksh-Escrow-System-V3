<?php
 header('Content-Type: application/json; charset=utf-8');
 $array= array();
      
        $array['BTCLTC'] = 4000;
        $array['BTCUSD'] = 39517;
        $array['BTCBRL'] = 182784.83;
        $array['USDBRL'] = 5.03;
        $array['USDBTC'] = 0.000028;
        $array['BRLBTC'] = 00.0000055;
        $array['BRLUSD'] = 0.20;
        
         $array['USDINR'] = 76.94;
        $array['BRLINR'] = 15.15;
      
            $array['INRUSD'] = 0.013;
        $array['INRBRL'] = 0.066;
            
            
            // print_r($array);
      echo json_encode($array);