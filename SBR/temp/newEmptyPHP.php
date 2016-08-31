<?php
        //    /isi tabel baru
$isibaru = $isibaru . "<tr>";     
       foreach ($isivertikal as $key=>$values) {
      
           foreach ($values as $isi) { 
       $isibaru = $isibaru . "<th rowspan='".$rspan[$key]."'>".$isi;
          $isibaru = $isibaru . "</th>";     }
       }
       $isibaru = $isibaru . "</tr>";     