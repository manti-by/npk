<?php
function detect_utf8($Str) {
	for ($i=0; $i<strlen($Str); $i++) {
		if (ord($Str[$i]) < 0x80) $n=0; # 0bbbbbbb
		elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
		elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
		elseif ((ord($Str[$i]) & 0xF0) == 0xF0) $n=3; # 1111bbbb
		else return false; # Does not match any model
		for ($j=0; $j<$n; $j++) { # n octets that match 10bbbbbb follow ?
		if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80)) return false;
		}
	}
	return true;
}

function utf8_win1251 ($s){
	$out="";
	$c1="";
	$byte2=false;
	for ($c=0;$c<strlen($s);$c++){
		$i=ord($s[$c]);
		if ($i<=127) $out.=$s[$c];
		if ($byte2){
			$new_c2=($c1&3)*64+($i&63);
			$new_c1=($c1>>2)&5;
			$new_i=$new_c1*256+$new_c2;
			if ($new_i==1025){
				$out_i=168;
			}else{
				if ($new_i==1105){
					$out_i=184;
				}else {
					$out_i=$new_i-848;
				}
			}
			$out.=chr($out_i);
			$byte2=false;
		}
		if (($i>>5)==6) {
			$c1=$i;
			$byte2=true;
		}
	}
	return $out;
}

function normal($s) {
    if (detect_utf8($s)) {
       $s = utf8_win1251 ( $s );
  };
  return $s;
}
?>
