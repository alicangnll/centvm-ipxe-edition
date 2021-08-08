systemctl stop firewalld
	systemctl disable firewalld
	setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
	chmod -R 777 /var/lib/tftpboot/data
	chown -R nobody:nobody /var/lib/tftpboot/data
	chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data
	semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data
	/sbin/restorecon -R -v /var/lib/tftpboot