	<?php
	include("func.php");
	$getir = new PXEBoot();
	  echo '<head>
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script><meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <title>PXE Installer</title>
	  </head>
	  <style>
	  @fontName:  -apple-system,
	  system-ui,
	  BlinkMacSystemFont,
	  "Segoe UI", "Roboto", "Ubuntu",
	  "Helvetica Neue", sans-serif;
	  @media (max-width:800px) {
	  body {
	  background-image: url("https://source.unsplash.com/1080x1920/?turkey,türkiye,atatürk,şehir,manzara,deniz");
	  align-items: center;
	  justify-content: center;
	  }
	  }
	  body {
	  background-image: url("https://source.unsplash.com/1920x1080/?turkey,türkiye,atatürk,şehir,manzara,deniz");
	  align-items: center;
	  justify-content: center;
	  }
	  </style>';
	  
	  if(file_exists("yukle.lock")) {
	  die('<div class="container mx-auto mt-5 card">
	  <div class="card-body">
	  <b>Yukle.Lock File Found</b>
	  <hr>
	  <code>Yukle.Lock dosyası bulundu</code><br>
	  <div class="form-group">
	  <br><br><a href="install.php?git=index" class="btn btn-dark">Refresh<br>
	  </a></div></div></div>');
	  } else {      
	  }
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
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>Merhabalar</b>
	  <hr></hr>
	  <p>PHP PXE Yönetim Paneli Server kurulumuna hoşgeldiniz. Devam etmek için lütfen devam tuşuna tıklayın.</p><br>
	  <b> Virtualbox 6.1 için kurmanız gereken dosya için <a href="https://download.virtualbox.org/virtualbox/6.1.8/Oracle_VM_VirtualBox_Extension_Pack-6.1.8.vbox-extpack">tıklayın</a></b>
	  <br><br>
	  <a type="button" href="install.php?git=first_install" class="btn btn-dark">Devam Et</a>
	  </div>
	  </div></body>
	  <script>
	  document.cookie = "rootpwd= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	  document.cookie = "netwdrv= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	  document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	  document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	  document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	  </script>';
	  break;

	  case 'first_install':
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>We are starting installation</b>
	  <hr></hr>
	  <p>We must be some control before PHP PXE Server Administration Panel installation.</p><br>
	  <b>First commands (You must be write this commands on commandline)</b><br>';
	  echo "<pre>
	  systemctl stop firewalld
	  systemctl disable firewalld
	  chown -R apache:apache ".dirname(__FILE__)."
	  chmod 777 -R ".dirname(__FILE__)."
	  setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
	  </pre>";
	  echo '<code>
	  '.$getir->funcControl('pdo_mysql').'<br>
	  '.$getir->funcControl('shell_exec').'<br></code><br>
	  <form action="install.php?git=license" method="post">
	  <div class="form-group">
	  <select id="lang" name="lang" class="form-control form-select" aria-label="Language">
	  <option selected>Language / Dil</option>
	  <option value="TR">Türkçe</option>
	  <option value="EN">English</option>
	  </select><br>
	  <select id="systype" name="systype" class="form-control form-select" aria-label="Boot Type">
	  <option selected>System Type</option>
	  <option value="centos">CentOS</option>
	  </select><br>
	  <input type="password" class="form-control mt-5" name="rootpwd" id="rootpwd" placeholder="Root Password"><br>
	  <select class="form-control form-select" aria-label="Network Driver" id="netwdrv" name="netwdrv">';
	  $netw = shell_exec('ls /sys/class/net');
	  $oparray = preg_split("#[\r\n]+#", $netw);
	  $array = array();
	  foreach($oparray as $line){
	  echo '<option value="'.$line.'">'.$line.'</option>';
	  }
	  echo '</select><br><br>
	  <button type="submit" class="btn btn-dark">İleri / Next</button><br>
	  </div></form>';
	  echo '</div></div></body>';
	  break;

	  case 'license':
	  $getir->ControlFile("update.json", "");
	  $getir->ControlCookie("systype");
	  $getir->ControlCookie("rootpwd");
	  $getir->ControlCookie("netwdrv");
	  $getir->ControlCookie("lang");
	  $data = '{"version_name": "Cygen","version": "11","lang" : "'.strip_tags($_POST["lang"]).'", "netw": "'.strip_tags($_POST["netwdrv"]).'"}';
	  $getir->ControlFile("update.json", $data);
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <code>'.strip_tags($data).'</code><br>
	  <a href="install.php?git=sql_install" class="btn btn-dark">Next</a>
	  </div></div></body>';
	  break;
	  
	  case 'sql_install':
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>SQL Bilgisi</b>
	  <hr></hr>
	  <p>Lütfen SQL bilgilerini giriniz.</p>
	  
	  <form action="install.php?git=sqlpost" method="post">
	  
	  <div class="form-group">
	  <label for="exampleInputEmail1">SQL Server</label>
	  <input type="text" class="form-control" name="sqlserver" placeholder="localhost">
	  </div>
	  
	  <div class="form-group">
	  <label for="exampleInputEmail1">SQL Username</label>
	  <input type="text" class="form-control" name="sqlusr" placeholder="root">
	  </div>
	  
	  <div class="form-group">
	  <label for="exampleInputEmail1">SQL Password</label>
	  <input type="password" class="form-control" name="sqlpasswd" placeholder="1234">
	  </div>
	  
	  <button type="submit" class="btn btn-dark">Next</button>
	  </form></div></div></body>';
	  break;
	  
	  case 'sqlpost':
	  $mysqlserv = strip_tags($_POST["sqlserver"]);
	  $mysqlusr = strip_tags($_POST["sqlusr"]);
	  $mysqlpass = strip_tags($_POST["sqlpasswd"]);
	  $conn = new mysqli($mysqlserv, $mysqlusr, $mysqlpass);
	  $conn->query("SET CHARACTER SET utf8");
	  $conn->query("SET NAMES utf8");
	  $sql = "CREATE DATABASE pxe_boot";
	  
	  if ($conn->query($sql) === TRUE) {
		
	  } else {
	  die('<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>MySQL Installation | ERROR</b>
	  <hr></hr>
	  <code>'.$conn->error.'<br></code><br>
	  <div class="form-group">
	  <br><br><a href="install.php?git=sql_install" " class="btn btn-dark">Tekrar Dene</button><br>
	  </div></div></div></body>');
	  }
	  $conn->close();
	  
	  $sql = mysqli_connect($mysqlserv, $mysqlusr, $mysqlpass, "pxe_boot");
	  $sqlSource = "CREATE TABLE `admin_list` (
	  `admin_id` int(11) NOT NULL,
	  `admin_email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	  `admin_usrname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	  `admin_passwd` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	  `admin_token` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	  `admin_yetki` varchar(255) COLLATE utf8_turkish_ci NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

	  INSERT INTO `admin_list` (`admin_id`, `admin_email`, `admin_usrname`, `admin_passwd`, `admin_token`, `admin_yetki`) VALUES
	  (1, 'xxx@xxx.com', 'alicangonullu', '060323f33140b4a86b53d01d726a45c7584a3a2b', '060323f33140b4a86b53d01d726a45c7584a3a2b', '1');
	  
	  CREATE TABLE `ipxe_list` (
	  `id` int(11) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `file_location` varchar(255) NOT NULL,
	  `other` text NOT NULL,
	  `kernel` varchar(255) NOT NULL,
	  `boot_type` varchar(255) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

	  ALTER TABLE `admin_list`
	  ADD PRIMARY KEY (`admin_id`);

	  ALTER TABLE `ipxe_list`
	  ADD PRIMARY KEY (`id`);

	  ALTER TABLE `admin_list`
	  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
	  
	  ALTER TABLE `ipxe_list`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
	  COMMIT;";
	  mysqli_multi_query($sql,$sqlSource);

	  $hostname = shell_exec("hostnamectl | grep -v hostname | grep -v Icon | grep -v Kernel | grep -v Chassis | grep -v Machine | grep -v Boot | grep -v Virtualization | grep -v CPE | grep -v Architecture");
	  $str1 = str_replace("Operating", "", $hostname);
	  $str2 = str_replace(":", "", $str1);
	  $str3 = str_replace("System", "", $str2);
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>MySQL Installation</b>
	  <hr></hr>
	  <code>System Type : '.trim($str3).'</code><br>
	  <a href="install.php?git=install" class="btn btn-dark">Next</a>
	  </div></div></body>';
	  break;


	 case 'install':
	  if (file_exists("backup/tftp")) {
	  unlink("backup/tftp");
	  touch("backup/tftp");
	  } else {
	  touch("backup/tftp");
	  }
	  if (file_exists("backup/pxeboot.conf")) {
	  unlink("backup/pxeboot.conf");
	  touch("backup/pxeboot.conf");
	  } else {
	  touch("backup/pxeboot.conf");
	  }
	if(strip_tags($_COOKIE["systype"]) == "centos") {

	
		$httpdcfg = "
	<IfModule mod_dav_fs.c>
	DAVLockDB /var/lib/dav/lockdb
	</IfModule>
	<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/html
	Alias /pxeboot /var/lib/tftpboot
	<Directory /var/lib/tftpboot>
	DAV On
	Options Indexes FollowSymLinks
	Require all granted
	</Directory>
	</VirtualHost>";
	$getir->ControlFile("backup/pxeboot.conf", $httpdcfg);

	$tftpconf = "
	service tftp
	{
		socket_type		= dgram
		protocol		= udp
		wait			= yes
		user			= root
		server			= /usr/sbin/in.tftpd
		server_args		= -c /var/lib/tftpboot
		disable			= no
		per_source		= 11
		cps			= 100 2
		flags			= IPv4
	}";
	$getir->ControlFile("backup/tftp", $tftpconf);
	
	  $systemctl_stopfirewall = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl stop firewalld";
	  $systemctl_disfirewall = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl disable firewalld";
	  
	  $installer = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k yum install -y epel-release ipxe-bootimgs tcpdump tftp tftp-server xinetd syslinux net-tools dnsmasq zip nfs-utils tar wget policycoreutils-python-utils";
	  $mk_syslinuxfolder = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k mkdir /var/lib/tftpboot/pxelinux.cfg";
      $copy_syslinux = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp -v /usr/share/syslinux/* /var/lib/tftpboot";
	  $wget1 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp /usr/share/ipxe/undionly.kpxe /var/lib/tftpboot/";
	  $wget2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k wget -P /var/lib/tftpboot https://raw.githubusercontent.com/ipxe/wimboot/master/wimboot  && wget -P /var/lib/tftpboot http://boot.ipxe.org/ipxe.efi";
	  
	  $cp_default = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/default /var/lib/tftpboot/pxelinux.cfg/";
	  shell_exec($cp_default);
	  
	  $stop_firewall = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl stop firewalld";
	  $disable_firewall = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl disable firewalld";
	  $enforce = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
	  $chforce = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod -R 777 /var/lib/tftpboot";
	  $choforce = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chown -R nobody:nobody /var/lib/tftpboot";
	  $chcforce = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot";
	  $semanage = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot";
	  $restoreconforce = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k /sbin/restorecon -R -v /var/lib/tftpboot";
	  
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>First Installation</b>
	  <hr></hr>
	  <code>
	  '.strip_tags($installer).'<br>
	  '.strip_tags($mk_syslinuxfolder).'<br>
	  '.strip_tags($copy_syslinux).'<br><br>
	  '.strip_tags($wget1).'<br><br>
	  '.strip_tags($wget2).'<br><br>
	  '.strip_tags($mkdir).'<br><br>
	  '.strip_tags($mkdir2).'<br><br>
	  '.strip_tags($cp_default).'<br><br>
	  
	  '.strip_tags($stop_firewall).'<br>
	  '.strip_tags($disable_firewall).'<br>
	  '.strip_tags($enforce).'<br>
	  '.strip_tags($chforce).'<br>
	  '.strip_tags($choforce).'<br>
	  '.strip_tags($chcforce).'<br>
	  '.strip_tags($semanage).'<br>
	  '.strip_tags($restoreconforce).'<br>
	  </code><br>
	  <div class="form-group">
	  <br><hr></hr>
	  <form action="install.php?git=install2" method="post">
  <div class="form-group">
  <label for="exampleInputEmail1">Server IP</label>
  <input type="text" class="form-control" name="serverip" placeholder="192.168.56.101">
  </div>

  <div class="form-group">
  <label for="exampleInputEmail1">Server Range Lowest IP</label>
  <input type="text" class="form-control" name="serverlowrange" placeholder="192.168.56.101">
  </div>

  <div class="form-group">
  <label for="exampleInputEmail1">Server Range Highest IP</label>
  <input type="text" class="form-control" name="serverhighrange" placeholder="192.168.56.254">
  </div>

  <div class="form-group">
  <label for="exampleInputEmail1">Server Gateway</label>
  <input type="text" class="form-control" name="servergateway" placeholder="255.255.255.0">
  </div>
  

  <button type="submit" class="btn btn-dark">İleri / Next</button>
  </form>
	  </div></div></div></body>';
	  } else {
		die('<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>First Installation</b>
	  <hr></hr>
	  <code>
	  System are not supporting please install CentOS and try again
	  </code><br>
	  <div class="form-group">
	  <br><br><a href="install.php" " class="btn btn-dark">Next</button><br>
	  </div></div></div></body>');
	  }
	  break;


	  case 'install2':
	if(strip_tags($_COOKIE["systype"]) == "centos") {
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
	interface='.strip_tags($_COOKIE["netwdrv"]).'
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
	
	$httpd_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/pxeboot.conf /etc/httpd/conf.d/";
	$tftp_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/tftp /etc/xinetd.d/";
	$dnsmasq_chmod = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod 777 /etc/dnsmasq.conf";
	$dnsmasq_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/dnsmasq.conf /etc/";
	$ipxe_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/boot.ipxe /var/lib/tftpboot/";
	shell_exec($httpd_cp);
	shell_exec($tftp_cp);
	shell_exec($dnsmasq_chmod);
	shell_exec($dnsmasq_cp);
	shell_exec($ipxe_cp);
	
	$system_dnsmasq = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl start dnsmasq";
	$system_dnsmasq2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl enable dnsmasq";
	$system_xinet = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl start xinetd";
	$system_xinet2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl enable xinetd";
	$system_httpd = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl restart httpd";
	shell_exec($system_dnsmasq);
	shell_exec($system_dnsmasq2);
	shell_exec($system_xinet);
	shell_exec($system_xinet2);
	shell_exec($system_httpd);
	  echo '<body class="container">
	  <br><br><br>
	  <div class="mx-auto card">
	  <div class="card-body">
	  <b>First Installation</b>
	  <hr></hr>
	  <code>
	  '.strip_tags($mkdir).'<br>
	  '.strip_tags($mkdir2).'<br>
	  '.strip_tags($httpd_cp).'<br>
	  '.strip_tags($tftp_cp).'<br>
	  '.strip_tags($dnsmasq_chmod).'<br>
	  '.strip_tags($dnsmasq_cp).'<br>
	  '.strip_tags($ipxe_cp).'<br>
	  '.strip_tags($system_dnsmasq).'<br>
	  '.strip_tags($system_dnsmasq2).'<br>
	  '.strip_tags($system_xinet).'<br>
	  '.strip_tags($system_xinet2).'<br>
	  '.strip_tags($system_httpd).'<br><br>
	  '.$select.'<br>
	  </code><br>
	  <div class="form-group">
	  <br><br><a href="install.php?git=install3" " class="btn btn-dark">Next</button><br>
	  </div></div></div></body>';
	  } else {
	  }
	  break;

	  case 'install3':
	  if(file_exists("yukle.lock")) {
	  unlink("yukle.lock");
	  $txt = md5(rand(5,15));
	  $fp = fopen("yukle.lock","a");
	  fwrite($fp,$txt);
	  fclose($fp);
	  } else {
	  $txt = md5(rand(5,15));
	  $fp = fopen("yukle.lock","a");
	  fwrite($fp,$txt);
	  fclose($fp);
	  }

	if(file_exists("backup/centvm.service")) {
	unlink("backup/centvm.service");
	} else {
	}
	if(file_exists("backup/custom_start.sh")) {
	unlink("backup/custom_start.sh");
	} else {
	}
	$select = "systemctl stop firewalld
	systemctl disable firewalld
	setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
	chmod -R 777 /var/lib/tftpboot
	chown -R nobody:nobody /var/lib/tftpboot
	chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot
	semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot
	/sbin/restorecon -R -v /var/lib/tftpboot";

	$file3 = fopen("backup/custom_start.sh", "a");
	fwrite($file3, strip_tags($select));
	fclose($file3);

	$cp_start = "cp ".dirname(__FILE__)."/backup/centvm.service /etc/systemd/system/";
	$sysctl_start = "systemctl start centvm.service";
	$sysctl_enable = "systemctl enable centvm.service";

	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Yükleme Bildirimi</b>
	<hr></hr>
	<p>Yükleme Tamamlandı. Artık Server hazır durumdadır.</p>
	  <code>Default User : alicangonullu<br>
	  Default Password : 19742008 <br>
	  HDD Image Create Code : qemu-img create -f raw /var/lib/tftpboot/disk1.img 10G <br>
	  HDD Image Info Code : qemu-img info /var/lib/tftpboot/disk1.img <br>
	  HDD Image Resize Code : qemu-img resize -f raw /var/lib/tftpboot/disk1.img 20G</br>
	  <br>
	  </code><br>
	  <a type="button" href="index.php" class="btn btn-dark">Devam Et</a>
	  </div>
	  </div></body>
	  <script>
	  function deleteAllCookies() {
		var cookies = document.cookie.split(";");
		for (var i = 0; i < cookies.length; i++) {
	  var cookie = cookies[i];
	  var eqPos = cookie.indexOf("=");
	  var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
	  document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
	  }
	  }
	  deleteAllCookies();
	  </script>';
	  break;
	  }
	?>
