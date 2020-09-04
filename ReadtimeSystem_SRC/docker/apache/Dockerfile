# docker/apache/Dockerfile
FROM centos:7.6.1810
RUN yum update -y
RUN yum -y remove httpd httpd.x86_64 httpd-tools.x86_64

# install leatest apache2.4.*
RUN yum install -y epel-release && \
    yum -y install https://repo.ius.io/ius-release-el7.rpm && \
    sed -i -e "s/enabled *= *1/enabled=0/g" /etc/yum.repos.d/ius.repo && \
    sed -i -e "s/enabled *= *1/enabled=0/g" /etc/yum.repos.d/epel.repo
RUN yum --enablerepo=epel -y install brotli
RUN yum --enablerepo=epel -y install nghttp2 && \
    yum -y install epel-release && \
    yum -y install mailcap system-logos && \
    yum -y install openssl && \
    yum -y --disablerepo=base,extras,updates --enablerepo=ius install httpd mod_ssl && \
    yum clean all
RUN sed -i -e "s|LoadModule mpm_prefork_module modules/mod_mpm_prefork.so|#LoadModule mpm_prefork_module modules/mod_mpm_prefork.so|" /etc/httpd/conf.modules.d/00-mpm.conf && \
    sed -i -e "s|#LoadModule mpm_event_module modules/mod_mpm_event.so|LoadModule mpm_event_module modules/mod_mpm_event.so|" /etc/httpd/conf.modules.d/00-mpm.conf
# make SSL server certificate
RUN mkdir -p /etc/ssl/private && \
    openssl req -new -newkey rsa:2048 -nodes -out /etc/ssl/private/server.csr -keyout /etc/ssl/private/server.key -subj "/C=/ST=/L=/O=/OU=/CN=*.s_leadtime.com" && \
    openssl x509 -days 3650 -req -signkey /etc/ssl/private/server.key -in /etc/ssl/private/server.csr -out /etc/ssl/private/server.crt

# virtual hosts
COPY ./docker/apache/httpd-vhosts.conf /etc/httpd/conf.d/httpd-vhosts.conf

# make
RUN mkdir -p "/var/www/s_leadtime"

# dockre can not use systemd without permission, apahce is started with httpd
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]