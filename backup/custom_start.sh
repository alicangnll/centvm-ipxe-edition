systemctl stop firewalld
	systemctl disable firewalld
	setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
	chmod -R 777 /var/lib/tftpboot
	chown -R nobody:nobody /var/lib/tftpboot
	chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot
	semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot
	/sbin/restorecon -R -v /var/lib/tftpboot