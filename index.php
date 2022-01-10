<?php
include("conn.php");

$getir = new PXEBoot();
$getir->ControlSession("yukle.lock");
$getir->funcControl('shell_exec');
$getir->funcControl('exec');
$getir->funcControl('system');

$getlang = file_get_contents("update.json");
$netwk = json_decode($getlang ,true);
$int = strip_tags($netwk["netw"]);

if(!isset($_GET['git'])) {
$sayfa = 'index';
} elseif(empty($_GET['git'])) {

if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) == "tr") {
$getir->Error("Sayfa Bulunamadı");
} else {
$getir->Error("Page Not Found");
}

} else {
$sayfa = strip_tags($_GET['git']);
}

switch ($sayfa) {
	
case 'index':
$getir->Head("PXE Boot");
setcookie("csrf_keygen", md5(sha1(rand(8, 15))), time()+3600);
echo '<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "csrf_keygen=; expires=Thu, 18 Dec 2013 12:00:00 UTC";
</script><style>
@media (max-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1080x1920/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  text-align: center;
  padding: 15px;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
}
@media (min-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1920x1080/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  text-align: center;
  top: 50%;
  font-weight: bold;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}

.container  {
border-radius: 20px;
}

}
</style>';
echo '<body class="container mx-auto text-center">
<div class="manzara">';
if(isset($_GET["err"])) {
echo '<script>Metro.infobox.create("<p>Hata<br><hr></hr> Invalid password or username</p>", "alert");</script>';
} else {
}
echo '<form data-role="validator" class="form-signin" action="index.php?git=postlgn" method="post">
	<br><br>
    <h1 class="text-center">PXE Boot Panel</h1><br><br>
      <br><br>
  <label for="inputEmail" class="sr-only">Kullanıcı Adı</label>
  <input type="text" name="mail" data-role="input" class="form-control" placeholder="Kullanıcı Adı" required><br>
    <br><br>  <br><br>
  <label for="inputPassword" class="sr-only">Şifre</label>
  <input type="password" data-role="keypad" data-clear-button="true" name="pass" class="form-control" placeholder="Şifre" required><br>
  
  <input type="hidden" name="csrfkey" class="form-control" value="'.$_COOKIE["csrf_keygen"].'" required><br>
  <button class="button primary" type="submit">Sign in</button>
  <br><br>
  <a class="button alert" href="index.php?git=passwordreset">Password Reset</button>
  <br><br>
</form>
  <p class="mt-5 mb-3 text-muted" style="background: rgba(0,0,0, 0.4);color:white;">&copy; 2019-2020</p><br><br>
</body></div>';
break;

case 'passwordreset':
$getir->Head("PXE Boot");
echo '<div class="container card mt-5">
<div class="window-caption">
<span class="title">Mesajlar / Messages</span>
<div class="buttons">
</div></div>
<div class="window-content p-2">
<form data-role="validator" class="form-signin" action="index.php?git=preset" method="post">
<label for="inputPassword" class="sr-only">Token</label>
<input type="password" data-role="keypad" name="token" class="form-control" placeholder="Token" required><br>
<label for="inputPassword" class="sr-only">E-Mail</label>
<input type="text" name="email" data-role="input" class="form-control" placeholder="E-Mail" required><br>
  <button class="button primary" type="submit">Reset / Sıfırla</button>
  <br>
</form>
</div>';
break;

case 'preset':
$getir->Head("PXE Boot");
if($_POST) {
if(isset($_POST["token"]) && isset($_POST["email"])) {
$email = strip_tags($_POST["email"]);
$token = sha1(md5($_POST["token"]));
$stmt = $db->query("SELECT * FROM admin_list WHERE admin_email = ".$db->quote(strip_tags($email))." AND admin_token = ".$db->quote(strip_tags($token))."");
if ($stmt->rowCount() > 0) {
$str = "0123456789";
$str = str_shuffle($str);
$str = substr($str, 0, 5);
$password = sha1(md5($str));
$db->query("UPDATE admin_list SET admin_passwd = ".$db->quote(strip_tags($password))." WHERE admin_email = ".$db->quote(strip_tags($email))."");
echo '
<br>
<div class="card-body">
<h4>Yeni şifren: '.$str.'</h4>
<hr></hr>
<p>NOT : Şifrenizi Kopyalayın ve <b>BİR YERE KAYDEDİN!</b></p>
<br>
<a class="button alert" href="index.php">Index</button>
</div></body>';
exit();
 } else {
echo '
<br>
<div class="card-body">
<b>Lütfen link yapınızı kontrol ediniz! / Please control link type</b>
<a class="button alert" href="index.php">Index</button>
</div></body>';
exit();
}

} else {
echo '
<br>
<div class="card-body">
<b>Something a fault! / Bir şeyler hatalı!</b>
</div></body>';
exit();
    }
} else {
$getir->Error("NON-POST");
}
break;
	
case 'postlgn':
if($_POST) {
$name = strip_tags($_POST["mail"]);
$pass = sha1(md5($_POST['pass']));
$csrf = strip_tags($_POST['csrfkey']);

if(isset($csrf)) {

} else {
$getir->Error("CSRF Not Found");
}

if(isset($name) && isset($pass)) {
$query = $db->query("SELECT * FROM admin_list WHERE admin_usrname =".$db->quote($name)." AND admin_passwd = ".$db->quote($pass)." ",PDO::FETCH_ASSOC);
if ( $say = $query -> rowCount() ){
if( $say > 0 ){
$getir_mail = str_replace("@", "", strip_tags($_POST["mail"]));
$json2 = json_decode("yukle.json", true);
session_destroy();
session_start();
$_SESSION["user_id"] = md5($getir_mail);
$_SESSION["admin_adi"] = $getir_mail;

$stmt = $db->prepare('SELECT * FROM admin_list WHERE admin_usrname = :admin');
$stmt->execute(array(':admin' => $name));
if($rowq = $stmt->fetch()) {
$_SESSION["perm"] = md5($rowq["admin_yetki"]);
$_SESSION["mail_adres"] = strip_tags($rowq["admin_email"]);
}
header('Location: index.php?git=pxeboot');
}
} else {
header('Location: index.php?err=1');
}
} else {
$getir->Error("Non-POST");
}
} else {
$getir->Error("Empty Character");
}
break;

case 'pxeboot':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>Welcome to PXE Boot Panel</h1>
<table class="products-table">
  <thead>
    <tr>
      <th>File</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>';
$_DIR = opendir("/var/lib/tftpboot");
while (($_DIRFILE = readdir($_DIR)) !== false){
if(!is_dir($_DIRFILE)){
$ext = pathinfo($_DIRFILE, PATHINFO_EXTENSION);
if(strstr($ext, 'c32')) {
} elseif(strstr($ext, 'bin')) {
} elseif(strstr($ext, 'pif')) {
} elseif(strstr($ext, 'sys')) {
} elseif(strstr($ext, 'efi')) {
} elseif(strstr($ext, 'com')) {
} elseif(strstr($ext, 'ipxe')) {
} elseif(strstr($ext, 'lst')) {
} elseif(strstr($ext, 'exe')) {
} elseif(strstr($ext, 'kpxe')) {
} elseif(strstr($ext, 'lkrn')) {
} elseif(strstr($ext, 'mbr')) {
} elseif(strstr($ext, 'vhd')) {
echo '<tr>
<td data-label="File">'.strip_tags($_DIRFILE).'</td>
<td data-label="Action"><a href="index.php?git=pxegen&name='.strip_tags($_DIRFILE).'">Create Boot File</a></td>
</tr>';
} elseif(strstr($ext, 'cfg')) {
} elseif(strstr($_DIRFILE, 'memdisk')) {
} elseif(strstr($_DIRFILE, 'wimboot')) {
} elseif(strstr($_DIRFILE, '.0')) {
} else {
echo '<tr>
      <td data-label="File">'.strip_tags($_DIRFILE).'</td>
      <td data-label="Action"><a href="index.php?git=pxegen&name='.strip_tags($_DIRFILE).'">Create Boot File</a></td>
    </tr>';
}
} else {
}

}
echo '</tbody></table>';

echo '<h1>PXE Direct Boot</h1>
<table class="products-table">
  <thead>
    <tr>
      <th>Name</th>
      <th>File</th>
	  <th>Kernel</th>
    </tr>
  </thead>
  <tbody>';
$stmt = $db->prepare('SELECT * FROM ipxe_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {
echo '<tr>
      <td data-label="Name">'.strip_tags($row["name"]).'</td>
      <td data-label="File"><a href="../pxeboot/'.strip_tags($row["file_location"]).'">'.strip_tags($row["file_location"]).'</a></td>
	  <td data-label="Kernel">'.strip_tags($row["kernel"]).'</td>
    </tr>';
}
echo '</tbody></table>';
echo '<h1>Chainloaders</h1>
<table class="products-table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Configs</th>
    </tr>
  </thead>
  <tbody>';
$stmt = $db->prepare('SELECT * FROM chain_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {
echo '<tr>
      <td data-label="File">'.strip_tags($row["chainname"]).'</td>
      <td data-label="Configs">'.strip_tags($row["chain_config"]).'</td>
    </tr>';
}
echo '</tbody></table>';
?>
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
</script>
<br><br>
<br><br>
<center>
<h1>Network Graph</h1><br>
<div class="text-clear" id="placeholder" style="width:100%;height:40%;"></div>
</center>
<?php
echo '</main></div>';
break;

case 'pxegen':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<div class="login-box">
<h1>Boot File Generator</h1>';
$getir->HeadMenu("PXE Panel");
echo '<form action="index.php?git=ppxegen" method="post">
<div class="user-box">
<b>PXE Name</b><br>
<input type="text" name="pxename" placeholder="FreeDOS" required="">
</div>
<div class="user-box">
<b>PXE Kernel</b><br>
<textarea type="text" name="kernel" placeholder="PXE Kernel / No add HTTP or HTTPS"></textarea>
</div>
<input type="hidden" name="pxefilename" value="'.strip_tags($_GET["name"]).'" required="">
<div class="user-box">
<b>PXE Other Config</b><br>
<textarea type="text" name="otherpxeconfig" placeholder="Other Configs"></textarea>
</div>

<div class="user-box">
<b>PXE Boot Type</b><br>
<select class="form-control form-select" aria-label="PXE Boot Type" id="boottype" name="boottype">
<option value="oth">Others / ISO</option>
</select>
</div>
<button type="submit" href="#">Generate</button>
</form></div></main></div>';
break;

case 'admin':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<div class="login-box">
<h1>Admin</h1>';
$getir->HeadMenu("PXE Panel");
echo '<table class="products-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Admin</th>
      <th>Action</th>
    </tr>
  </thead><tbody>';
  $stmt = $db->prepare('SELECT * FROM admin_list ORDER BY admin_id');
  $stmt->execute();
  while($row = $stmt->fetch()) {
 echo '<tr>
      <td data-label="#">'.intval($row["admin_id"]).'</td>
      <td data-label="Admin">'.strip_tags($row["admin_usrname"]).'</td>
      <td data-label="Action"><a href="index.php?git=editadmin&id='.intval($row["admin_id"]).'">Edit</a> | <a href="index.php?git=deladmin&id='.intval($row["admin_id"]).'">Delete</a></td>
    </tr>';
  }
echo '</tbody></table>
<br><a class="btn btn-primary" href="index.php?git=addadmin">Add Admin</a>
</div></main>';
break;

case 'addadmin':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<div class="login-box">
<h1>Add Admin</h1>';
$getir->HeadMenu("PXE Panel");
echo '<form action="index.php?git=paddadmin" method="post">
    <div class="user-box">
  <b>Admin E-Mail</b><br>
      <input type="email" name="adminemail" placeholder="Admin E-Mail" value="'.strip_tags($row["admin_email"]).'" required="">
    </div>
    <div class="user-box">
  <b>Admin Username</b><br>
      <input type="text" name="adminusr" placeholder="Admin Username" value="'.strip_tags($row["admin_usrname"]).'" required="">
    </div>
      <div class="user-box">
    <b>Admin Password</b><br>
      <input type="password" name="adminpwd" placeholder="Admin Password" required="">
    </div>
      <div class="user-box">
    <b>Admin Token</b><br>
      <input type="password" name="admintkn" placeholder="Admin Token" required="">
    </div>
    <button type="submit" href="#">Submit</button>
  </form>';
break;

case 'paddadmin':
$getir->logincheck($_SESSION['admin_adi']);
$update = $db->prepare("INSERT INTO admin_list(admin_email, admin_usrname, admin_passwd, admin_token, admin_yetki) VALUES (:email, :usr, :pwd, :tkn, :perm) ");
$update->bindValue(':email', strip_tags($_POST["adminemail"]));
$update->bindValue(':usr', strip_tags($_POST["adminusr"]));
$update->bindValue(':pwd', sha1(md5($_POST["adminpwd"])));
$update->bindValue(':tkn', sha1(md5($_POST["admintkn"])));
$update->bindValue(':perm', "1");
$update->execute();
if($update){
  echo "<script LANGUAGE='JavaScript'>
  window.alert('Updated');
  window.location.href='index.php?git=admin';
  </script>";
} else {
  echo "<script LANGUAGE='JavaScript'>
  window.alert('Not Updated');
  window.location.href='index.php?git=admin';
  </script>";
}
break;

case 'editadmin':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<div class="login-box">
<h1>Edit Admin</h1>';
$getir->HeadMenu("PXE Panel");
$stmt = $db->prepare('SELECT * FROM admin_list WHERE admin_id = :postID');
$stmt->execute(array(':postID' => intval($_GET['id'])));
if($row = $stmt->fetch()) {
echo '<form action="index.php?git=peditadmin&id='.intval($_GET['id']).'" method="post">
    <div class="user-box">
  <b>Admin E-Mail</b><br>
      <input type="email" name="adminemail" placeholder="Admin E-Mail" value="'.strip_tags($row["admin_email"]).'" required="">
    </div>
    <div class="user-box">
  <b>Admin Username</b><br>
      <input type="text" name="adminusr" placeholder="Admin Username" value="'.strip_tags($row["admin_usrname"]).'" required="">
    </div>
      <div class="user-box">
    <b>Admin Password</b><br>
      <input type="password" name="adminpwd" placeholder="Admin Password" required="">
    </div>
      <div class="user-box">
    <b>Admin Token</b><br>
      <input type="password" name="admintkn" placeholder="Admin Token" required="">
    </div>
    <button type="submit" href="#">Submit</button>
  </form>';
}
break;

case 'peditadmin':
$getir->logincheck($_SESSION['admin_adi']);
$update = $db->prepare("UPDATE admin_list SET admin_email = :email, admin_usrname = :usr, admin_passwd = :pwd, admin_token = :tkn WHERE admin_id = :gonderid");
$update->bindValue(':gonderid', intval($_GET["id"]));
$update->bindValue(':email', strip_tags($_POST["adminemail"]));
$update->bindValue(':usr', strip_tags($_POST["adminusr"]));
$update->bindValue(':pwd', sha1(md5($_POST["adminpwd"])));
$update->bindValue(':tkn', sha1(md5($_POST["admintkn"])));
$update->execute();
if($update){
  echo "<script LANGUAGE='JavaScript'>
  window.alert('Updated');
  window.location.href='index.php?git=admin';
  </script>";
} else {
  echo "<script LANGUAGE='JavaScript'>
  window.alert('Not Updated');
  window.location.href='index.php?git=admin';
  </script>";
}
break;

case 'deladmin':
$getir->logincheck($_SESSION['admin_adi']);
if(intval($_GET['id']) == 1) {
  die("Could not delete");
} else {
  
}
$stmt = $db->prepare('DELETE FROM admin_list WHERE admin_id = :postID') ;
$stmt->execute(array(':postID' => intval($_GET['id'])));
if($stmt){
echo '<script>
alert("Admin Deleted");
window.location.replace("index.php?git=admin")
</script>';
} else {
echo '<script>
alert("Admin Could Not Deleted");
window.location.replace("index.php?git=admin")</script>';
}
break;

case 'ppxegen':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<div class="login-box">
<h1>Boot File Generator</h1>';
$getir->HeadMenu("PXE Panel");
$update = $db->prepare("INSERT INTO ipxe_list(name, file_location, other, kernel, boot_type) VALUES (:ad, :filelocation, :other, :kernel, :boot) ");
  $update->bindValue(':ad', strip_tags($_POST["pxename"]));
  $update->bindValue(':filelocation', strip_tags($_POST["pxefilename"]));
  $update->bindValue(':other', strip_tags($_POST["otherpxeconfig"]));
  $update->bindValue(':kernel', strip_tags($_POST["kernel"]));
  $update->bindValue(':boot', strip_tags($_POST["boottype"]));
  $update->execute();
  if($row = $update->rowCount()) {
    echo "<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='index.php?git=pxeboot';
    </script>";
  } else {
    echo "<script LANGUAGE='JavaScript'>
    window.alert('Unsuccesfully Updated');
    window.location.href='index.php?git=pxeboot';
    </script>";
    unlink($data);
  }
echo '</div></main></div>';
break;

case 'dhcpoption':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>DHCP Options</h1>';
$getir->HeadMenu("PXE Panel");
echo '<br><div class="login-box">
  <h2>Login</h2>
  <form action="index.php?git=pdhcpoption" method="post">
  <div class="user-box">
  <b>Network Driver</b><br>
  <select class="form-control form-select" aria-label="Network Driver" id="intname" name="intname">';
  $netw = shell_exec('ls /sys/class/net');
  $oparray = preg_split("#[\r\n]+#", $netw);
  $array = array();
  foreach($oparray as $line){
  echo '<option value="'.$line.'">'.$line.'</option>';
  }
  echo '</select></div>
    <div class="user-box">
	<b>Server IP</b><br>
      <input type="text" name="serverip" placeholder="192.168.56.101" required="">
    </div>
    <div class="user-box">
	<b>Server Range Lowest IP</b><br>
      <input type="text" name="serverlowrange" placeholder="192.168.56.101" required="">
    </div>
	    <div class="user-box">
		<b>Server Range Highest IP</b><br>
      <input type="text" name="serverhighrange" placeholder="192.168.56.254" required="">
    </div>
	    <div class="user-box">
		<b>Server Gateway</b><br>
      <input type="text" name="servergateway" placeholder="255.255.255.0" required="">
    </div>
    <button type="submit" href="#">Generate</button>
  </form>
</div>';
echo '</main></div>';
break;

case 'pdhcpoption':
$getir->logincheck($_SESSION['admin_adi']);
if (file_exists("backup/dnsmasq.conf")) {
unlink("backup/dnsmasq.conf");
touch("backup/dnsmasq.conf");
} else {
touch("backup/dnsmasq.conf");
}
	$select = '#VBox Config
	# DHCP on Virtualbox https://jpmens.net/2018/03/07/dhcp-in-virtualbox-hosts/
	# Vbox Extension Pack : https://download.virtualbox.org/virtualbox/6.1.8/Oracle_VM_VirtualBox_Extension_Pack-6.1.8.vbox-extpack
	# Enable DHCP Server
	port=0
	log-dhcp
	interface='.strip_tags($_POST["intname"]).'
	dhcp-range='.strip_tags($_POST["serverlowrange"]).','.strip_tags($_POST["serverhighrange"]).','.strip_tags($_POST["servergateway"]).',12h
	dhcp-option=option:dns-server,'.strip_tags($_POST["serverip"]).'

	#load ipxe.efi from tftp server

	dhcp-boot=tag:!ipxe,undionly.kpxe
	dhcp-match=set:ipxe,175 # gPXE/iPXE sends a 175 option.
	dhcp-boot=tag:!ipxe,undionly.kpxe
	dhcp-boot=http://'.strip_tags($_POST["serverip"]).'/boot.php

	pxe-service=tag:!ipxe,x86PC,"AliNetBoot",undionly.kpxe

	#TFTP settings
	enable-tftp
	tftp-root=/var/lib/tftpboot
	log-queries
	conf-dir=/etc/dnsmasq.d';
	$file3 = fopen("backup/dnsmasq.conf", "a");
	fwrite($file3, $select);
	fclose($file3);
	
	$dnsmasq_chmod = "chmod 777 /etc/dnsmasq.conf";
	$dnsmasq_cp = "cp ".dirname(__FILE__)."/backup/dnsmasq.conf /etc/";
	shell_exec($dnsmasq_chmod);
	shell_exec($dnsmasq_cp);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>DHCP Process</h1>
<pre>
'.$dnsmasq_chmod.'<br>
'.$dnsmasq_cp.'<br>
'.shell_exec("cat /etc/dnsmasq.conf").'<br>
</pre>
<a href="index.php?git=pxeboot">Main Page</a><br>';
$getir->HeadMenu("PXE Panel");
echo '</main></div>';
break;

case 'pxeinfo':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
echo '<div class="container">';
$getir->NavBar();
$dnsmasq_stat = "systemctl status dnsmasq";
echo '<main class="main">
<h1>PXE Information</h1>
<pre>
'.shell_exec($dnsmasq_stat).'<br>
</pre><br>';
echo '</main></div>';
break;

case 'networkinfo':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<br><br><br><br>
<pre>'.shell_exec("netstat -o state established | grep -a CONNECTED").'</pre>
</main></div>';
break;


case 'phpinfo':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>PHP Information</h1>
<br><br><br><br>
<pre>'.shell_exec("php -v").'</pre>
</main></div>';
break;

case 'repair':
$getir->logincheck($_SESSION['admin_adi']);
$sys = "
//Commands for repair
systemctl stop firewalld
setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
chmod -R 777 /var/lib/tftpboot
chown -R nobody:nobody /var/lib/tftpboot
chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot
semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot
/sbin/restorecon -R -v /var/lib/tftpboot";
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>Repair Information</h1>
<br><br>';
$getir->HeadMenu("PXE Panel");
echo '
<pre>'.$sys.'</pre>
</main></div>';
break;

case 'addchain':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
$getir->NavBar();
echo '<main class="main">
<div class="login-box">

<form action="index.php?git=pchainadd" method="post">

<div class="user-box">
<b>Chain Name</b><br>
<input type="text" name="chainname" placeholder="GRUB Windows" required="">
</div>

<div class="user-box">
<b>Chain Config</b><br>
<textarea type="text" name="chainconfig" placeholder="command1;command2;...;commandN"></textarea>
</div>

<button type="submit" >Generate</button>
</form></div></main>';
break;

case 'pchainadd':
$getir->logincheck($_SESSION['admin_adi']);
  $update = $db->prepare("INSERT INTO chain_list(chainname, chain_config) VALUES (:ad, :ccfg) ");
  $update->bindValue(':ad', strip_tags($_POST["chainname"]));
  $update->bindValue(':ccfg', strip_tags($_POST["chainconfig"]));
  $update->execute();
  if($row = $update->rowCount()) {
    echo "<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='index.php?git=pxeboot';
    </script>";
  } else {
    echo "<script LANGUAGE='JavaScript'>
    window.alert('Unsuccesfully Updated');
    window.location.href='index.php?git=pxeboot';
    </script>";
  }
break;

case 'addimage':
$getir->logincheck($_SESSION['admin_adi']);
$getir->HeadMenu("PXE Panel");
echo '<div class="container">
';
$getir->NavBar();
echo '<main class="main">
<h1>Add Image</h1>
<br><br><br><br><br><br><br><br>
<div class="login-box">
<form action="index.php?git=addwget" method="post">
<div class="user-box">
  <b>Wget File</b><br>
  <input type="text" name="wgetiso" placeholder="http://xxxx.com/xxx" required="">
  </div>
<br>
<button type="submit" href="#">GET</button>
</form></div>
<br>
</main></div>';
break;

case 'addwget':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>Add Image</h1>
<br><br><br><br><br><br><br><br>';
$getir->HeadMenu("PXE Panel");
$getir->WGet($_POST["wgetiso"]);
echo '</main></div>';
break;

case 'pxecikis':
$getir->logincheck($_SESSION['admin_adi']);
session_destroy();
echo '<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>';
break;

case 'shell':
$getir->logincheck($_SESSION['admin_adi']);
echo '<div class="container">';
$getir->NavBar();
echo '<main class="main">
<h1>Web Command</h1>
<br><br><br><br><br><br><br><br>';
$getir->HeadMenu("PXE Panel");
if (!empty($_POST['al'])) {
    $cmd = shell_exec($_POST['al']);
	$data = htmlspecialchars($cmd, ENT_QUOTES, 'UTF-8');
}

echo '<div class="login-box">
        <form method="post">
            <label for="al"><strong>Command</strong></label>
            <div class="user-box">
                <input type="text" name="al" id="al" value="'.strip_tags($_POST["al"]).'" onfocus="this.setSelectionRange(this.value.length, this.value.length);" autofocus required><br>
                <button type="submit">Execute</button>
            </div>
        </form>';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
echo '<h2>Output</h2>';
if (isset($cmd)) {
echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<pre style="width:100%;height:30%;">'.$data.'</pre><br>';
} else {
echo '<pre><small>No result.</small></pre>';
}
}
echo '</div></main></div>';
break;

default:
$getir->Error('Sayfa Bulunamadı');
break;
}
?>
