
PASSWORD=etuCHONDxyfNE6hs88sR
DB=/opt/lampp/bin/mariadb

setup:
	systemctl start docker
	@ docker run --detach \
  --name mariadb \
  -e MARIADB_ROOT_PASSWORD=$(PASSWORD) \
  -p 3306:3306 \
  mariadb:latest

start:
	@ docker start mariadb
	
login:
	 @ $(DB) -h 127.0.0.1 -P 3306 -u root -p"$(PASSWORD)"

do:
	 @ $(DB) -h 127.0.0.1 -P 3306 -u root -p"$(PASSWORD)" < schema.sql

stop:
	@ docker stop mariadb
	@ docker rm mariadb



