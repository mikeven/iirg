<?php

function getDR( $num ){
    $dr = 0;
	$number = strval($num); 
    for( $i = 0; $i < strlen( $number ); $i++ ){ 
       $dr += $number[$i]; 
    }
    return $dr;
}

function digitRootSort($a) {
   $size = count($a);
    for ($i=0; $i<$size; $i++) {
        for ($j=0; $j<$size-1-$i; $j++) {
            if ( ( getDR( $a[$j+1] ) < getDR($a[$j]) ) && (true) ) {
                $aux = $a[$j];
				$a[$j] = $a[$j+1];
				$a[$j+1] = $aux;
            }
        }
    }
    return $a;
}
$a = array(13, 20, 7, 4);

$sorted = digitRootSort($a);
print_r($sorted);

/*$number = strval(135);
echo $number;*/

?>