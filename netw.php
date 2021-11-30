<?php   
include("conn.php");
set_time_limit(0);
if (file_exists("yukle.lock")) {
} else {
die("Yükleme yapılmamış (Eksik dosya : yukle.lock)<br><a href='install.php'>Yükle</a>");
}
$getir = new PXEBoot();
$getir->logincheck($_SESSION['admin_adi']);
$durum = strip_tags($_GET["id"]);
$int = strip_tags($_GET["crd"]);

if(strip_tags($durum) == "1") {
session_start();
$rx[] = @file_get_contents("/sys/class/net/".$int."/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/".$int."/statistics/tx_bytes");
sleep(1);
$rx[] = @file_get_contents("/sys/class/net/".$int."/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/".$int."/statistics/tx_bytes");
    
$tbps = $tx[1] - $tx[0];
$rbps = $rx[1] - $rx[0];
    
$round_rx=round($rbps/1024, 2);
$round_tx=round($tbps/1024, 2);
    
$time=date("U")."000";
$_SESSION['rx'][] = "[".$time.", ".$round_rx."]";
$_SESSION['tx'][] = "[".$time.", ".$round_tx."]";
$data['label'] = $int;
$data['data'] = $_SESSION['rx'];

if (count($_SESSION['rx'])>60) {
$x = min(array_keys($_SESSION['rx']));
unset($_SESSION['rx'][$x]);
}
    
echo '{"label":"'.$int.'","data":['.implode($_SESSION['rx'], ",").']}';
} elseif(strip_tags($durum) == "2") {
$uptime = shell_exec("uptime -p");
$uptimerep = str_replace("up", "", $uptime);
echo '{"name":"uptime","data": "'.trim($uptimerep).'"}';
} elseif(strip_tags($durum) == "3") { 

$free = shell_exec('free');
$free = (string)trim($free);
$free_arr = explode("\n", $free);
$mem = explode(" ", $free_arr[1]);
$mem = array_filter($mem);
$mem = array_merge($mem);
$memory_usage = $mem[2]/$mem[1]*100;
echo '{"name":"freeram","data": "'.trim(intval($memory_usage)).'"}';

} elseif(strip_tags($durum) == "4") { 
function get_server_cpu_usage(){
	$load = sys_getloadavg();
	return intval($load[0]);
}
$cpumodelexec = shell_exec("cat /proc/cpuinfo | grep 'model name' | uniq");
$cpumodel2 = str_replace("model", "", $cpumodelexec);
$cpumodel3 = str_replace(":", "", $cpumodel2);
$cpumodel = str_replace("name", "", $cpumodel3);
echo '{"name":"cpuload","data": "'.trim(get_server_cpu_usage()).'","data2": "'.trim($cpumodel).'"}';
} elseif(strip_tags($durum) == "5") { 
$total = (disk_total_space("/")/1024);
$available = (disk_free_space("/")/1024);
$used = ($total - $available);
$hdd_usage = intval($used/$total*100);
echo '{"name":"hdd","data": "'.trim($hdd_usage).'"}';
} elseif(strip_tags($durum) == "6") {
$dir = "/var/lib/tftpboot/data/iso";
$scanned_directory = array_diff(scandir($dir), array('..', '.'));
echo '{"name":"filename","data": ""}';
} elseif(strip_tags($durum) == "7") {
}	else {
}
?>
