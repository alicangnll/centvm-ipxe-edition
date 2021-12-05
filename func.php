<?php
class PXEBoot {

function Repair() {
$cp_start = "cp ".dirname(__FILE__)."/backup/centvm.service /etc/systemd/system/";
$sysctl_start = "systemctl start centvm.service";
$sysctl_enable = "systemctl enable centvm.service";

$stop_firewall = "systemctl stop firewalld";
$disable_firewall = "systemctl disable firewalld";
$enforce = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chforce = "chmod -R 777 /var/lib/tftpboot";
$choforce = "chown -R nobody:nobody /var/lib/tftpboot";
$chcforce = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot";
$semanage = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot";
$restoreconforce = "/sbin/restorecon -R -v /var/lib/tftpboot";
$selectz = '<br>'.$stop_firewall.'<br>'.$disable_firewall.'<br>'.$enforce.'<br>'.$chforce.'<br>'.$choforce.'<br>'.$chcforce.'<br>'.$semanage.'<br>'.$restoreconforce.'<br>';
$info = '<p><p>Bilgi<br><hr></hr><pre>'.$cp_start.'<br>'.$sysctl_start.'<br>'.$sysctl_enable.'<br>'.$selectz.'<br></pre></p>';
echo '<script>
function BilgiRepair() {
Metro.infobox.create("'.$info.'", "info");
}
</script>
<center><br><a class="button success mt-5" onclick="BilgiRepair()" role="button">Repair / Bakım</a></center>';
}

function extControl($name) {
  if (!extension_loaded(''.strip_tags($name).'')) {
    echo('The '.strip_tags($name).' extension is not loaded.');
}
}

function funcControl($name) {
  if (!function_exists(''.strip_tags($name).'')) {
    echo('The '.strip_tags($name).' function is not loaded.');
}
}

function getIPAddress() {
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

if(filter_var($client, FILTER_VALIDATE_IP))
{
    $ip = strip_tags($client);
}
elseif(filter_var($forward, FILTER_VALIDATE_IP))
{
    $ip = strip_tags($forward);
}
else
{
    $ip = strip_tags($remote);
}

echo $ip;
}
  function Head($baslik) {
    echo '<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <link rel="stylesheet" href="login/css/metro-all.min.css">
    <link rel="stylesheet" href="login/css/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="login/js/metro.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>'.strip_tags($baslik).'</title>
</head>';
}
  function HeadMenu($baslik) {
    echo '<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <link rel="stylesheet" href="menu/menu.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="menu/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>'.strip_tags($baslik).'</title>
</head>';
}

function NavBar() {
echo '<nav class="menu">
			<ul>
				<input type="radio" name="menu" id="archive" checked>
				<li>
					<label for="archive" class="title"><i class="fa fa-folder"></i> PXE Menu</label>
					<a class="data" href="index.php?git=pxeboot">Main Page</a>
					<a class="data" href="index.php?git=dhcpoption">DHCP Options</a>
					<a class="data" href="index.php?git=addimage">Add File</a>
					<a class="data" href="index.php?git=addchain">Add Chain</a>
					<a class="data" href="index.php?git=repair">Repair Configuration</a>
					<a class="data" href="#">Mount List</a>
				</li>
				<input type="radio" name="menu" id="edit">
				<li>
					<label for="edit" class="title"><i class="fa fa-edit"></i> Admin</label>
					<a class="data" href="#">Add Admin</a>
					<a class="data" href="#">Delete Admin</a>
					<a class="data" href="#">Edit Admin</a>
					<a class="data" href="index.php?git=pxecikis">Exit</a>
				</li>
				<input type="radio" name="menu" id="tools">
				<li>
					<label for="tools" class="title"><i class="fa fa-gavel"></i> Informations</label>
					<a class="data" href="index.php?git=phpinfo">PHP</a>
					<a class="data" href="index.php?git=networkinfo">DHCP</a>
					<a class="data" href="#">TFTP</a>
					<a class="data" href="index.php?git=pxeinfo">PXE</a>
					<a class="data" href="index.php?git=shell">Online CommandLine</a>
				</li>
			</ul>
		</nav>';
}

function logincheck($data) {
if (!isset($data)) {
if (!isset($_SESSION["perm"])) {
echo '<script>
alert("Permission Error");
console.log("Permission Error");
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>';
} else {
}
echo '
<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>';
} else {
}

}
function limit($iterable, $limit) {
foreach ($iterable as $key => $value) {
if (!$limit--) break;
yield $key => $value;
}
}

function Error($errorname) {
die('
<td align="center" width="90" height="90">
<br></br>
<b><u>'.strip_tags($errorname).'</u></b>
<hr></hr>
<p>'.strip_tags($errorname).'</p></td>');
}
  
function WGet($wget) {
$yuklenecek_dosya = "wget -P /var/lib/tftpboot ".escapeshellarg($wget)."";
$stop_firewall = "systemctl stop firewalld";
$syslinuxcfg = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chmod_cfg = "chmod -R 777 /var/lib/tftpboot";
$chown_cfg = "chown -R nobody:nobody /var/lib/tftpboot";
$chcon_cfg = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot";
$semanage_cfg = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot";
$restorecon_cfg = "/sbin/restorecon -R -v /var/lib/tftpboot";

echo '
<div class="container card mt-5 mt-5">
<div class="window-caption">
<div class="buttons">
</div></div>

<div class="window-content p-2">
<pre>
'.shell_exec($yuklenecek_dosya).'<br>
'.shell_exec($stop_firewall).'<br>
'.shell_exec($syslinuxcfg).'<br>
'.shell_exec($chmod_cfg).'<br>
'.shell_exec($chown_cfg).'<br>
'.shell_exec($chcon_cfg).'<br>
'.shell_exec($semanage_cfg).'<br>
'.shell_exec($restorecon_cfg).'<br>
</pre><br>
</div></div></body>';
}

function ControlCookie($post) {
	if(empty($_POST["".$post.""])) {
		die('<div class="mx-auto card">
		<div class="card-body">
		<b>Doğrulama Yapılamadı</b>
		<hr>
		<code>Boot Type Not Found</code><br>
		<div class="form-group">
		<br><br><a href="install.php" class="btn btn-dark">Yenile / Refresh<br>
		</a></div></div></div>');
	} else {
		setcookie($post, strip_tags($_POST["".$post.""]), time()+3600);
	}
}

function ControlFile($file, $txt2) {
$vowels = array("\\");
$txt = str_replace($vowels , "", $txt2);
if (file_exists("".$file."")) {
unlink("".$file."");
$fp = fopen("".$file."","a");
fwrite($fp,$txt);
fclose($fp);
} else {
$fp = fopen("".$file."","a");
fwrite($fp,$txt);
fclose($fp);
}
}

function ControlSession($file) {
set_time_limit(0);
if (file_exists("".$file."")) {
} else {
$getir->Error("Yükleme yapılmamış (Eksik dosya : yukle.lock)<br><a href='install.php'>Yükle</a>");
}
}

function ServerLog($int) {
?>
<head>
<script type="text/javascript" src="menu/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
	
<script id="source" language="javascript" type="text/javascript">
$(document).ready(function() {
var options = {
lines: { show: true },
points: { show: true },
xaxis: { mode: "time" }
};
var data = [];
var placeholder = $("#placeholder");
$.plot(placeholder, data, options);
var iteration = 0;
function fetchData() {
++iteration;
    
function onDataReceived(series) {

data = [ series ];

$.plot($("#placeholder"), data, options);
fetchData();
}
    
$.ajax({
url: "netw.php?id=1&crd=<?php echo $int; ?>",
method: 'GET',
dataType: 'json',
success: onDataReceived
});

}
setTimeout(fetchData, 1000);
});
</script></head>
<br><br><center>
<div class="text-clear" id="placeholder" style="width:100%;height:70%;"></div>
</center>
<?php
}
}
?>
