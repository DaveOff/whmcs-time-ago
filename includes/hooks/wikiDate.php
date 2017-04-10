<?php

function wikiDateConfig() {
	$date_tooltip = true;	// true : Enable Show Date in Tooltip 		- 	false : Disable Show Date in Tooltip
	$persian_date = true;	// true : Enable Persian Date in Tooltip 	- 	false : Disable Persian Date in Tooltip
	
	return array('date_tooltip' => $date_tooltip, 'persian_date' => $persian_date);
}
function wikiPersianDate($format, $timestamp = '', $none = '', $time_zone = 'Asia/Tehran', $wikiNumber = 'en')
{
    $T_sec = 0;
    
    if ($time_zone != 'local')
        date_default_timezone_set(($time_zone == '') ? 'Asia/Tehran' : $time_zone);
    $ts   = $T_sec + (($timestamp == '' or $timestamp == 'now') ? time() : wikiNumber($timestamp));
    $date = explode('_', date('H_i_j_n_O_P_s_w_Y', $ts));


    list($j_y, $j_m, $j_d) = WikiGregorianToPersianDate($date[8], $date[3], $date[2]);
	

	$year =  $j_y;
	$month =  $j_m;
	$day =  $j_d;
	
    $doy = ($j_m < 7) ? (($j_m - 1) * 31) + $j_d - 1 : (($j_m - 7) * 30) + $j_d + 185;
    $kab = ($j_y % 33 % 4 - 1 == (int) ($j_y % 33 * .05)) ? 1 : 0;
    $sl  = strlen($format);
	
	

	
	
    $out = '';
    for ($i = 0; $i < $sl; $i++) {
        $sub = substr($format, $i, 1);
        if ($sub == '\\') {
            $out .= substr($format, ++$i, 1);
            continue;
        }
        switch ($sub) {
            
            case 'E':
            case 'R':
            case 'x':
            case 'X':
                $out .= 'http://milad.in';
                break;
            
            case 'B':
            case 'e':
            case 'g':
            case 'G':
            case 'h':
            case 'I':
            case 'T':
            case 'u':
            case 'Z':
                $out .= date($sub, $ts);
                break;
            
            case 'a':
                $out .= ($date[0] < 12) ? 'ق.ظ' : 'ب.ظ';
                break;
            
            case 'A':
                $out .= ($date[0] < 12) ? 'قبل از ظهر' : 'بعد از ظهر';
                break;
            
            case 'b':
                $out .= (int) ($j_m / 3.1) + 1;
                break;
            
            case 'c':
                $out .= $j_y . '/' . $j_m . '/' . $j_d . ' ،' . $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[5];
                break;
            
            case 'C':
                $out .= (int) (($j_y + 99) / 100);
                break;
            
            case 'd':
                $out .= ($day < 10) ? '0' . $day : $day;
                break;
            
            case 'D':
                $out .= wikiPersianDateWords(array(
                    'kh' => $date[7]
                ), ' ');
                break;
            
            case 'f':
                $out .= wikiPersianDateWords(array(
                    'ff' => $j_m
                ), ' ');
                break;
            
            case 'F':
                $out .= wikiPersianDateWords(array(
                    'mm' => $j_m
                ), ' ');
                break;
            
            case 'H':
                $out .= $date[0];
                break;
            
            case 'i':
                $out .= $date[1];
                break;
            
            case 'j':
                $out .= $j_d;
                break;
            
            case 'J':
                $out .= wikiPersianDateWords(array(
                    'rr' => $j_d
                ), ' ');
                break;
            
            case 'k';
                $out .= wikiNumber(100 - (int) ($doy / ($kab + 365) * 1000) / 10, $wikiNumber);
                break;
            
            case 'K':
                $out .= wikiNumber((int) ($doy / ($kab + 365) * 1000) / 10, $wikiNumber);
                break;
            
            case 'l':
                $out .= wikiPersianDateWords(array(
                    'rh' => $date[7]
                ), ' ');
                break;
            
            case 'L':
                $out .= $kab;
                break;
            
            case 'm':
                $out .= ($month > 9) ? $month : '0' . $month;
                break;
            
            case 'M':
                $out .= wikiPersianDateWords(array(
                    'km' => $j_m
                ), ' ');
                break;
            
            case 'n':
                $out .= $j_m;
                break;
            
            case 'N':
                $out .= $date[7] + 1;
                break;
            
            case 'o':
                $jdw = ($date[7] == 6) ? 0 : $date[7] + 1;
                $dny = 364 + $kab - $doy;
                $out .= ($jdw > ($doy + 3) and $doy < 3) ? $j_y - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $j_y + 1 : $j_y);
                break;
            
            case 'O':
                $out .= $date[4];
                break;
            
            case 'p':
                $out .= wikiPersianDateWords(array(
                    'mb' => $j_m
                ), ' ');
                break;
            
            case 'P':
                $out .= $date[5];
                break;
            
            case 'q':
                $out .= wikiPersianDateWords(array(
                    'sh' => $j_y
                ), ' ');
                break;
            
            case 'Q':
                $out .= $kab + 364 - $doy;
                break;
            
            case 'r':
                $key = wikiPersianDateWords(array(
                    'rh' => $date[7],
                    'mm' => $j_m
                ));
                $out .= $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[4] . ' ' . $key['rh'] . '، ' . $j_d . ' ' . $key['mm'] . ' ' . $j_y;
                break;
            
            case 's':
                $out .= $date[6];
                break;
            
            case 'S':
                $out .= 'ام';
                break;
            
            case 't':
                $out .= ($j_m != 12) ? (31 - (int) ($j_m / 6.5)) : ($kab + 29);
                break;
            
            case 'U':
                $out .= $ts;
                break;
            
            case 'v':
                $out .= wikiPersianDateWords(array(
                    'ss' => ($j_y % 100)
                ), ' ');
                break;
            
            case 'V':
                $out .= wikiPersianDateWords(array(
                    'ss' => $j_y
                ), ' ');
                break;
            
            case 'w':
                $out .= ($date[7] == 6) ? 0 : $date[7] + 1;
                break;
            
            case 'W':
                $avs = (($date[7] == 6) ? 0 : $date[7] + 1) - ($doy % 7);
                if ($avs < 0)
                    $avs += 7;
                $num = (int) (($doy + $avs) / 7);
                if ($avs < 4) {
                    $num++;
                } elseif ($num < 1) {
                    $num = ($avs == 4 or $avs == (($j_y % 33 % 4 - 2 == (int) ($j_y % 33 * .05)) ? 5 : 4)) ? 53 : 52;
                }
                $aks = $avs + $kab;
                if ($aks == 7)
                    $aks = 0;
                $out .= (($kab + 363 - $doy) < $aks and $aks < 3) ? '01' : (($num < 10) ? '0' . $num : $num);
                break;
            
            case 'y':
                $out .= substr($j_y, 2, 2);
                break;
            
            case 'Y':
                $out .= $year;
                break;
            
            case 'z':
                $out .= $doy;
                break;
            
            default:
                $out .= $sub;
        }
    }

    return ($wikiNumber != 'en') ? wikiNumber($out, 'fa', '.') : $out;
}
function WikiGregorianToPersianDate($gy, $gm, $gd, $mod = '')
{
    list($gy, $gm, $gd) = explode('_', wikiNumber($gy . '_' . $gm . '_' . $gd));
    /* <= Extra :اين سطر ، جزء تابع اصلي نيست */
    $g_d_m = array(0,31,59,90,120,151,181,212,243,273,304,334);
    $jy    = ($gy <= 1600) ? 0 : 979;
    $gy -= ($gy <= 1600) ? 621 : 1600;
    $gy2  = ($gm > 2) ? ($gy + 1) : $gy;
    $days = (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
    $jy += 33 * ((int) ($days / 12053));
    $days %= 12053;
    $jy += 4 * ((int) ($days / 1461));
    $days %= 1461;
    $jy += (int) (($days - 1) / 365);
    if ($days > 365)
        $days = ($days - 1) % 365;
    $jm = ($days < 186) ? 1 + (int) ($days / 31) : 7 + (int) (($days - 186) / 30);
    $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
    return ($mod == '') ? array(
        $jy,
        $jm,
        $jd
    ) : $jy . $mod . $jm . $mod . $jd;
}
function wikiPersianDateWords($array, $mod = '')
{
    foreach ($array as $type => $num) {
        $num = (int) wikiNumber($num);
        switch ($type) {
            
            case 'ss':
                $sl  = strlen($num);
                $xy3 = substr($num, 2 - $sl, 1);
                $h3  = $h34 = $h4 = '';
                if ($xy3 == 1) {
                    $p34 = '';
                    $k34 = array('ده','یازده','دوازده','سیزده','چهارده','پانزده','شانزده','هفده','هجده','نوزده');
                    $h34 = $k34[substr($num, 2 - $sl, 2) - 10];
                } else {
                    $xy4 = substr($num, 3 - $sl, 1);
                    $p34 = ($xy3 == 0 or $xy4 == 0) ? '' : ' و ';
                    $k3  = array('','','بیست','سی','چهل','پنجاه','شصت','هفتاد','هشتاد','نود');
                    $h3  = $k3[$xy3];
                    $k4  = array('','یک','دو','سه','چهار','پنج','شش','هفت','هشت','نه');
                    $h4  = $k4[$xy4];
                }
                $array[$type] = (($num > 99) ? str_replace(array('12','13','14','19','20'), array('هزار و دویست','هزار و سیصد','هزار و چهارصد','هزار و نهصد','دوهزار'), substr($num, 0, 2)) . ((substr($num, 2, 2) == '00') ? '' : ' و ') : '') . $h3 . $p34 . $h34 . $h4;
                break;
            
            case 'mm':
                $key          = array('فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند');
                $array[$type] = $key[$num - 1];
                break;
            
            case 'rr':
                $key = array('یک','دو','سه','چهار','پنج','شش','هفت','هشت','نه','ده','یازده','دوازده','سیزده','چهارده','پانزده','شانزده','هفده','هجده','نوزده','بیست','بیست و یک','بیست و دو','بیست و سه','بیست و چهار','بیست و پنج','بیست و شش','بیست و هفت','بیست و هشت','بیست و نه','سی','سی و یک');
                $array[$type] = $key[$num - 1];
                break;
            
            case 'rh':
                $key = array('یکشنبه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه','شنبه');
                $array[$type] = $key[$num];
                break;
            
            case 'sh':
                $key = array('مار','اسب','گوسفند','میمون','مرغ','سگ','خوک','موش','گاو','پلنگ','خرگوش','نهنگ');
                $array[$type] = $key[$num % 12];
                break;
            
            case 'mb':
                $key = array('حمل','ثور','جوزا','سرطان','اسد','سنبله','میزان','عقرب','قوس','جدی','دلو','حوت');
                $array[$type] = $key[$num - 1];
                break;
            
            case 'ff':
                $key = array('بهار','تابستان','پاییز','زمستان');
                $array[$type] = $key[(int) ($num / 3.1)];
                break;
            
            case 'km':
                $key = array('فر','ار','خر','تی‍','مر','شه‍','مه‍','آب‍','آذ','دی','به‍','اس‍');
                $array[$type] = $key[$num - 1];
                break;
            
            case 'kh':
                $key = array('ی','د','س','چ','پ','ج','ش');
                $array[$type] = $key[$num];
                break;
            
            default:
                $array[$type] = $num;
        }
    }
    return ($mod == '') ? $array : implode($mod, $array);
}
function wikiNumber($str, $mod = 'en', $mf = '٫')
{
    $num_a = array('0','1','2','3','4','5','6','7','8','9','.');
    $key_a = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹',$mf);
    return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
}
function wikiDate($format, $time) {
	
	
	$wikiDateConfig 	= wikiDateConfig();
	$now 		= strtotime(date(str_replace('/', '-',$format)));
	$time		= strtotime(str_replace('/', '-',$time));
	
	$timestamp 	= ($now < $time) ? ($time - $now) : ($now - $time);

	if($timestamp == 0)
		return 'امروز';
	
	if($timestamp < 1)
		return;
	
	if ($now < $time) {
		$tense = "دیگر";
		$values = array(24*60*60 => 'روز', 60*60 => 'ساعت', 60 => 'دقیقه', 1 => 'ثانیه');
	} else {
		$tense = "پیش";
		$values = array(12*30*24*60*60 => 'سال', 30*24*60*60 => 'ماه', 24*60*60*7 => 'هفته', 24*60*60 => 'روز', 60*60 => 'ساعت', 60 => 'دقیقه', 1 => 'ثانیه');
	}
	
	foreach($values as $secs=>$point) {
		$res = $timestamp / $secs;
		
		if ($wikiDateConfig['date_tooltip'] == true) {
			if ($wikiDateConfig['persian_date'] == true) {
				if ($res >= 1)
					return "<span title='". wikiPersianDate($format, $time) ."'>". round($res) . " {$point} {$tense}" . "</span>";
			} else {
				if ($res >= 1)
					return "<span title='". date($format, $time) ."'>". round($res) . " {$point} {$tense}" . "</span>";
			}
		} else {
			if ($res >= 1)
				return round($res) . " {$point} {$tense}";
		}
	}
}




function findPt($data) {
	
	if( preg_match("/\d{4}(\/|-)\d{2}(\/|-)\d{2}/", $data, $output_array) ) return "Y/m/d";
	if( preg_match("/\d{4}(\/|-)\d{2}(\/|-)\d{2} (\d*):(\d*)/", $data, $output_array) ) return "Y/m/d H:i";
	if( preg_match("/\d{4}(\/|-)\d{2}(\/|-)\d{2} (\d*):(\d*):(\d*)/", $data, $output_array) ) return "Y/m/d H:i:s";
	if( preg_match("/\d{4}(\/|-)\d{2}(\/|-)\d{2}/", $data, $output_array) ) return "d/m/Y";
	if( preg_match("/\d{2}(\/|-)\d{2}(\/|-)\d{4} (\d*):(\d*)/", $data, $output_array) ) return "d/m/Y H:i";
	if( preg_match("/\d{2}(\/|-)\d{2}(\/|-)\d{4} (\d*):(\d*):(\d*)/", $data, $output_array) ) return "d/m/Y H:i:s";	
	if( preg_match("/(\d*):(\d*):(\d*) \d{4}(\/|-)\d{2}(\/|-)\d{2}/", $data, $output_array) ) return "H:i:s Y/m/d";
	if( preg_match("/(\d*):(\d*):(\d*) \d{2}(\/|-)\d{2}(\/|-)\d{4}/", $data, $output_array) ) return "H:i:s d/m/Y";
	if( preg_match("/(\d*):(\d*) \d{4}(\/|-)\d{2}(\/|-)\d{2}/", $data, $output_array) ) return "H:i Y/m/d";
	if( preg_match("/(\d*):(\d*) \d{2}(\/|-)\d{2}(\/|-)\d{4}/", $data, $output_array) ) return "H:i d/m/Y";		
	if( preg_match("/^(\d*):(\d*)/", $data, $output_array) ) return "H:i";
	if( preg_match("/^(\d*):(\d*):(\d*)/", $data, $output_array) ) return "H:i:s";
}






add_hook('ClientAreaPage', 1, function($wikiDateReplace) {
    $wikiDateReplace['wikiDate'] = TRUE;
	
	
	
    foreach ($wikiDateReplace['domains'] as &$domains) {
        $domains['registrationdate'] = wikiDate(findPt($domains['registrationdate']), $domains['registrationdate']) . '</br>' . wikiPersianDate(findPt($domains['registrationdate']), strtotime(str_replace('/', '-',$domains['registrationdate'])));		
		if ($domains['nextduedate'] != '-') {
			$domains['nextduedate'] = wikiDate(findPt($domains['nextduedate']), $domains['nextduedate']) . '</br>' . wikiPersianDate(findPt($domains['nextduedate']), strtotime(str_replace('/', '-',$domains['nextduedate'])));	
		}
        $domains['expirydate'] = wikiDate(findPt($domains['expirydate']), $domains['expirydate']) . '</br>' . wikiPersianDate(findPt($domains['expirydate']), strtotime(str_replace('/', '-',$domains['expirydate'])));	;
    }
	
	
	
    foreach ($wikiDateReplace['services'] as &$services) {
        $services['regdate'] = wikiDate(findPt($services['normalisedRegDate']), $services['normalisedRegDate']);
		if ($services['nextduedate'] != '-') {
			$services['nextduedate'] =  wikiDate(findPt($services['normalisedNextDueDate']), $services['normalisedNextDueDate']) . '</br>' . wikiPersianDate(findPt($services['normalisedNextDueDate']), strtotime($services['normalisedNextDueDate']));
		}
    }
	

    foreach ($wikiDateReplace['tickets'] as &$tickets) {
	
		$date2 = $tickets['date'];
		$date3 = $tickets['lastreply'];

        $tickets['date'] 		= wikiDate(findPt($tickets['date']), $tickets['date']) . '</br>' . wikiPersianDate(findPt($date2), strtotime(str_replace('/', '-',$date2)));

        $tickets['lastreply'] 	= wikiDate(findPt($tickets['lastreply']), $tickets['lastreply']) . '</br>' . wikiPersianDate(findPt($date3), strtotime(str_replace('/', '-',$date3)));
    }
	

	
    foreach ($wikiDateReplace['replies'] as &$replies) {
        $replies['date'] 		= wikiDate(findPt($replies['date']), $replies['date']);
    }
    foreach ($wikiDateReplace['ascreplies'] as &$ascreplies) {
        $ascreplies['date'] 	= wikiDate(findPt($ascreplies['date']), $ascreplies['date']);
    }
    foreach ($wikiDateReplace['descreplies'] as &$descreplies) {
        $descreplies['date'] 	= wikiDate(findPt($descreplies['date']), $descreplies['date']);
    }
	
	
	
	
	
    foreach ($wikiDateReplace['invoices'] as &$invoices) {
		
		if( $invoices['normalisedDateCreated'] !== "0000-00-00" && $invoices['normalisedDateCreated'] !== "00-00-0000" )
        $invoices['datecreated'] = wikiDate(findPt($invoices['normalisedDateCreated']), $invoices['normalisedDateCreated']) . '</br>' . wikiPersianDate(findPt($invoices['normalisedDateCreated']), strtotime(str_replace('/', '-',$invoices['normalisedDateCreated'])));

        $invoices['datedue'] 	= wikiDate(findPt($invoices['normalisedDateDue']), $invoices['normalisedDateDue']) . '</br>' . wikiPersianDate(findPt($invoices['normalisedDateDue']), strtotime(str_replace('/', '-',$invoices['normalisedDateDue'])));
    }
	
	
	
	
    
    if ($wikiDateReplace['date']) {
        $wikiDateReplace['jfulldate'] = wikiDate("l ، j F Y", $wikiDateReplace['date']);
    }
	

    if (strpos($_SERVER['REQUEST_URI'],'viewinvoice') === false) {
		$datefields = array('registrationdate','nextduedate','expirydate','regdate','lastupdate','date','duedate','datepaid','datecreated','datedue');
		foreach ($datefields as $datefield) {
			if ($wikiDateReplace[$datefield] ) {
				
				if( strstr($wikiDateReplace[$datefield], ':') )
					$wikiDateReplace[$datefield] = wikiDate(findPt($wikiDateReplace[$datefield]), $wikiDateReplace[$datefield]);
				else
				$wikiDateReplace[$datefield] = wikiDate(findPt($wikiDateReplace[$datefield]), $wikiDateReplace[$datefield]) . '</br>' . wikiPersianDate(findPt($wikiDateReplace[$datefield]), strtotime(str_replace('/', '-',$wikiDateReplace[$datefield])));
				
			}	
		}
    }
    
    return $wikiDateReplace;
});

