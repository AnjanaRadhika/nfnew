<?php

$phone = "";

if(!empty($_POST["mob_number"])) {
  $phone = $_POST["mob_number"];
}

$phone = "+91".$phone;

$OTPValue=rand(111111,999999);
//$OTPValue=666666;
$APIKey='0333826c-3e2a-11e8-a895-0200cd936042';

session_start();
$_SESSION['OTPSent']= $OTPValue;

### Sending OTP to Customer's Number
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$APIKey/SMS/$phone/$OTPValue";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_CAINFO, 'cert/cacert.pem');
curl_setopt($ch, CURLOPT_CAPATH, 'cert/cacert.pem');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


$response = curl_exec($ch);
if ($response === false) $response = curl_error($ch);
curl_close($ch);

echo stripslashes($response);


/*function getinternationalformatphoneno($number, $country) {
    //The mobile numbers you need to internationalise:
    $numbers = array(
        $number => $country
    );

    //An array of country codes:
    $country_codes = array(
    	'AC' => '247',
    	'AD' => '376',
    	'AE' => '971',
    	'AF' => '93',
    	'AG' => '1268',
    	'AI' => '1264',
    	'AL' => '355',
    	'AM' => '374',
    	'AO' => '244',
    	'AQ' => '672',
    	'AR' => '54',
    	'AS' => '1684',
    	'AT' => '43',
    	'AU' => '61',
    	'AW' => '297',
    	'AX' => '358',
    	'AZ' => '994',
    	'BA' => '387',
    	'BB' => '1246',
    	'BD' => '880',
    	'BE' => '32',
    	'BF' => '226',
    	'BG' => '359',
    	'BH' => '973',
    	'BI' => '257',
    	'BJ' => '229',
    	'BL' => '590',
    	'BM' => '1441',
    	'BN' => '673',
    	'BO' => '591',
    	'BQ' => '599',
    	'BR' => '55',
    	'BS' => '1242',
    	'BT' => '975',
    	'BW' => '267',
    	'BY' => '375',
    	'BZ' => '501',
    	'CA' => '1',
    	'CC' => '61',
    	'CD' => '243',
    	'CF' => '236',
    	'CG' => '242',
    	'CH' => '41',
    	'CI' => '225',
    	'CK' => '682',
    	'CL' => '56',
    	'CM' => '237',
    	'CN' => '86',
    	'CO' => '57',
    	'CR' => '506',
    	'CU' => '53',
    	'CV' => '238',
    	'CW' => '599',
    	'CX' => '61',
    	'CY' => '357',
    	'CZ' => '420',
    	'DE' => '49',
    	'DJ' => '253',
    	'DK' => '45',
    	'DM' => '1767',
    	'DO' => '1809',
    	'DO' => '1829',
    	'DO' => '1849',
    	'DZ' => '213',
    	'EC' => '593',
    	'EE' => '372',
    	'EG' => '20',
    	'EH' => '212',
    	'ER' => '291',
    	'ES' => '34',
    	'ET' => '251',
    	'EU' => '388',
    	'FI' => '358',
    	'FJ' => '679',
    	'FK' => '500',
    	'FM' => '691',
    	'FO' => '298',
    	'FR' => '33',
    	'GA' => '241',
    	'GB' => '44',
    	'GD' => '1473',
    	'GE' => '995',
    	'GF' => '594',
    	'GG' => '44',
    	'GH' => '233',
    	'GI' => '350',
    	'GL' => '299',
    	'GM' => '220',
    	'GN' => '224',
    	'GP' => '590',
    	'GQ' => '240',
    	'GR' => '30',
    	'GT' => '502',
    	'GU' => '1671',
    	'GW' => '245',
    	'GY' => '592',
    	'HK' => '852',
    	'HN' => '504',
    	'HR' => '385',
    	'HT' => '509',
    	'HU' => '36',
    	'ID' => '62',
    	'IE' => '353',
    	'IL' => '972',
    	'IM' => '44',
    	'IN' => '91',
    	'IO' => '246',
    	'IQ' => '964',
    	'IR' => '98',
    	'IS' => '354',
    	'IT' => '39',
    	'JE' => '44',
    	'JM' => '1876',
    	'JO' => '962',
    	'JP' => '81',
    	'KE' => '254',
    	'KG' => '996',
    	'KH' => '855',
    	'KI' => '686',
    	'KM' => '269',
    	'KN' => '1869',
    	'KP' => '850',
    	'KR' => '82',
    	'KW' => '965',
    	'KY' => '1345',
    	'KZ' => '7',
    	'LA' => '856',
    	'LB' => '961',
    	'LC' => '1758',
    	'LI' => '423',
    	'LK' => '94',
    	'LR' => '231',
    	'LS' => '266',
    	'LT' => '370',
    	'LU' => '352',
    	'LV' => '371',
    	'LY' => '218',
    	'MA' => '212',
    	'MC' => '377',
    	'MD' => '373',
    	'ME' => '382',
    	'MF' => '590',
    	'MG' => '261',
    	'MH' => '692',
    	'MK' => '389',
    	'ML' => '223',
    	'MM' => '95',
    	'MN' => '976',
    	'MO' => '853',
    	'MP' => '1670',
    	'MQ' => '596',
    	'MR' => '222',
    	'MS' => '1664',
    	'MT' => '356',
    	'MU' => '230',
    	'MV' => '960',
    	'MW' => '265',
    	'MX' => '52',
    	'MY' => '60',
    	'MZ' => '258',
    	'NA' => '264',
    	'NC' => '687',
    	'NE' => '227',
    	'NF' => '672',
    	'NG' => '234',
    	'NI' => '505',
    	'NL' => '31',
    	'NO' => '47',
    	'NP' => '977',
    	'NR' => '674',
    	'NU' => '683',
    	'NZ' => '64',
    	'OM' => '968',
    	'PA' => '507',
    	'PE' => '51',
    	'PF' => '689',
    	'PG' => '675',
    	'PH' => '63',
    	'PK' => '92',
    	'PL' => '48',
    	'PM' => '508',
    	'PR' => '1787',
    	'PR' => '1939',
    	'PS' => '970',
    	'PT' => '351',
    	'PW' => '680',
    	'PY' => '595',
    	'QA' => '974',
    	'QN' => '374',
    	'QS' => '252',
    	'QY' => '90',
    	'RE' => '262',
    	'RO' => '40',
    	'RS' => '381',
    	'RU' => '7',
    	'RW' => '250',
    	'SA' => '966',
    	'SB' => '677',
    	'SC' => '248',
    	'SD' => '249',
    	'SE' => '46',
    	'SG' => '65',
    	'SH' => '290',
    	'SI' => '386',
    	'SJ' => '47',
    	'SK' => '421',
    	'SL' => '232',
    	'SM' => '378',
    	'SN' => '221',
    	'SO' => '252',
    	'SR' => '597',
    	'SS' => '211',
    	'ST' => '239',
    	'SV' => '503',
    	'SX' => '1721',
    	'SY' => '963',
    	'SZ' => '268',
    	'TA' => '290',
    	'TC' => '1649',
    	'TD' => '235',
    	'TG' => '228',
    	'TH' => '66',
    	'TJ' => '992',
    	'TK' => '690',
    	'TL' => '670',
    	'TM' => '993',
    	'TN' => '216',
    	'TO' => '676',
    	'TR' => '90',
    	'TT' => '1868',
    	'TV' => '688',
    	'TW' => '886',
    	'TZ' => '255',
    	'UA' => '380',
    	'UG' => '256',
    	'UK' => '44',
    	'US' => '1',
    	'UY' => '598',
    	'UZ' => '998',
    	'VA' => '379',
    	'VA' => '39',
    	'VC' => '1784',
    	'VE' => '58',
    	'VG' => '1284',
    	'VI' => '1340',
    	'VN' => '84',
    	'VU' => '678',
    	'WF' => '681',
    	'WS' => '685',
    	'XC' => '991',
    	'XD' => '888',
    	'XG' => '881',
    	'XL' => '883',
    	'XN' => '857',
    	'XN' => '858',
    	'XN' => '870',
    	'XP' => '878',
    	'XR' => '979',
    	'XS' => '808',
    	'XT' => '800',
    	'XV' => '882',
    	'YE' => '967',
    	'YT' => '262',
    	'ZA' => '27',
    	'ZM' => '260',
    	'ZW' => '263',
    );

    //The default country code if the recipient's is unknown:
    $default_country_code  = '91';

    //Loop through the numbers and make them international format:
    foreach ( $numbers as $n => $c )
    {
        //Remove any parentheses and the numbers they contain:
        $n = preg_replace("/\([0-9]+?\)/", "", $n);

        //Strip spaces and non-numeric characters:
        $n = preg_replace("/[^0-9]/", "", $n);

        //Strip out leading zeros:
        $n = ltrim($n, '0');

        //Look up the country dialling code for this number:
        if ( array_key_exists($c, $country_codes)  ) {
            $pfx = $country_codes[$c];
        } else {
            $pfx = $default_country_code;
        }

        //Check if the number doesn't already start with the correct dialling code:
        if ( !preg_match('/^'.$pfx.'/', $n)  ) {
            $n = $pfx.$n;
        }

        //return the converted number:
        return $n;

        //Outputs: 17123456781 447123456782 447123456783 447123456784 447123456785 17123456786
        }
}*/
?>
