<?php
include("conn.php");
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: max-age=0, must-revalidate');
echo '#!ipxe
set menu-timeout 0
set submenu-timeout ${menu-timeout}
isset ${menu-default} || set menu-default exit
cpuid --ext 29 && set arch x64 || set arch x86
cpuid --ext 29 && set archl amd64 || set archl i386
menu Please choose an operating system to boot
';

echo '
:start
menu iPXE boot menu
item --gap --             ------------------------- Operating systems ------------------------------
';
$stmt = $db->prepare('SELECT * FROM ipxe_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {
echo 'item --key p '.strtolower(strip_tags(str_replace(" ", "", $row["name"]))).'     '.strtoupper(strip_tags($row["name"])).' installation
';
}

echo 'item --gap --             ------------------------- Advanced options -------------------------------
item --key c config       Configure settings
item shell                Drop to iPXE shell
item reboot               Reboot computer
item
item --key x exit         Exit iPXE and continue BIOS boot
choose --timeout ${menu-timeout} --default ${menu-default} selected || goto cancel
set menu-timeout 0
goto ${selected}
';

$stmt = $db->prepare('SELECT * FROM ipxe_list ORDER BY id');
$stmt->execute();
while($row = $stmt->fetch()) {

if(strip_tags($row["boot_type"]) == "oth") {
echo '
:'.strtolower(strip_tags(str_replace(" ", "", $row["name"]))).'';

if(empty(strtolower(strip_tags($row["kernel"])))) {
} else {
if(strstr($row["kernel"], "http")) { 
echo '
kernel '.strtolower(strip_tags($row["kernel"])).'';
} else {
echo '
kernel http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strtolower(strip_tags($row["kernel"])).'';
}

}
if(empty(strtolower(strip_tags($row["other"])))) {

if(strstr($row["file_location"], "http")) { 
echo '
initrd '.strip_tags($row["file_location"]).'
boot || goto failed
';
} else {
echo '
initrd http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strip_tags($row["file_location"]).'
boot || goto failed
';
}
} else {

if(strstr($row["file_location"], "http")) { 
echo '
initrd '.strip_tags($row["file_location"]).'
'.strip_tags($row["other"]).'
boot || goto failed
';
} else {
echo '
initrd http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strip_tags($row["file_location"]).'
'.strip_tags($row["other"]).'
boot || goto failed
';
}

}

} elseif(strip_tags($row["boot_type"]) == "vhdx") { 
if(empty(strtolower(strip_tags($row["other"])))) {
echo '
:'.strtolower(strip_tags(str_replace(" ", "", $row["name"]))).'';

if(strstr($row["kernel"], "http")) { 
echo '
kernel '.strtolower(strip_tags($row["kernel"])).'';
} else {
echo '
kernel http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strtolower(strip_tags($row["kernel"])).'';
}
if(strstr($row["file_location"], "http")) { 
echo '
initrd '.strip_tags($row["file_location"]).'
boot || goto failed';
} else {
echo '
initrd http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strip_tags($row["file_location"]).'
boot || goto failed';
}

} else {
echo '
:'.strtolower(strip_tags(str_replace(" ", "", $row["name"]))).'';

if(strstr($row["kernel"], "http")) { 
echo '
kernel '.strtolower(strip_tags($row["kernel"])).'';
} else {
echo '
kernel http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strtolower(strip_tags($row["kernel"])).'';
}

if(strstr($row["file_location"], "http")) { 
echo '
initrd '.strip_tags($row["file_location"]).'
boot || goto failed
';
} else {
echo '
initrd http://'.$_SERVER['HTTP_HOST'].'/pxeboot/'.strip_tags($row["file_location"]).'
boot || goto failed
';
}
}

} else {
echo '
boot || goto failed';
}

}

echo '

:failed
echo Booting failed, dropping to shell
goto shell

:shell
echo Type "exit" to get the back to the menu
shell
set menu-timeout 0
set submenu-timeout 0
goto start

:back
exit';
?>