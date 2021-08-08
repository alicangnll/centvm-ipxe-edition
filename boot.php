<?php
include("conn.php");
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: max-age=0, must-revalidate');
echo '#!ipxe
menu Please choose an operating system to boot';

$stmt = $db->prepare('SELECT * FROM ipxe_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {
echo '
item '.strtolower(strip_tags($row["name"])).' '.strtoupper(strip_tags($row["name"])).' installation';
}

$stmt = $db->prepare('SELECT * FROM ipxe_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {
	
if(strip_tags($row["boot_type"]) == "oth") {
echo '

:'.strtolower(strip_tags($row["name"])).'
set '.strtolower(strip_tags($row["name"])).'_link http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strip_tags($row["file_location"]).'';

if(empty(strtolower(strip_tags($row["kernel"])))) {
} else {
echo '
kernel http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strtolower(strip_tags($row["kernel"])).'';
}
if(empty(strtolower(strip_tags($row["other"])))) {
echo '
initrd ${'.strtolower(strip_tags($row["name"])).'_link}
boot || goto failed
';

} else {

echo '
initrd ${'.strtolower(strip_tags($row["name"])).'_link}
'.strip_tags($row["other"]).'
boot || goto failed
';

}
} elseif(strip_tags($row["boot_type"]) == "vhd") { 
echo '
:'.strtolower(strip_tags($row["name"])).'
kernel memdisk raw harddisk
initrd '.strip_tags($row["file_location"]).'.vhd
boot || goto failed';
} else {
echo '
boot || goto failed';
}

}

echo '
:failed
echo Booting failed, dropping to shell
goto shell

:back
exit';
?>