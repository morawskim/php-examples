JMETER_VERSION := '5.4.1'
MYSQL_CONNECTION_VERSION := '8.0.26'

setup-jmeter:
	@wget -Ojmeter.tgz https://dlcdn.apache.org//jmeter/binaries/apache-jmeter-$(JMETER_VERSION).tgz
	@tar -xvf jmeter.tgz
	@wget -Omysql-connector-java.tar.gz https://cdn.mysql.com/archives/mysql-connector-java-8.0/mysql-connector-java-$(MYSQL_CONNECTION_VERSION).tar.gz
	@tar -xvf mysql-connector-java.tar.gz
	@cp mysql-connector-java-$(MYSQL_CONNECTION_VERSION)/mysql-connector-java-$(MYSQL_CONNECTION_VERSION).jar apache-jmeter-$(JMETER_VERSION)/lib
	@rm jmeter.tgz
	@rm mysql-connector-java.tar.gz
	@rm -r mysql-connector-java-$(MYSQL_CONNECTION_VERSION)

prepare:
	docker-compose up -d
	sleep 10 # todo change to waitfordocker...
	docker exec -i `docker-compose ps -q mysql` mysql -udbuser -puserpassword  -Ddbname < init-tables.sql
	docker-compose exec cli php ./generate-fake-data.php > data.sql
	docker-compose exec mysql mysql -sN -udbuser -puserpassword -Ddbname -e 'TRUNCATE refresh_tokens_innodb;'
	docker-compose exec mysql mysql -sN -udbuser -puserpassword -Ddbname -e 'TRUNCATE refresh_tokens_memory;'
	docker exec -i `docker-compose ps -q mysql` mysql -udbuser -puserpassword  -Ddbname < data.sql
	docker-compose exec mysql mysql -sN -udbuser -puserpassword -Ddbname -e 'SELECT refresh_token FROM refresh_tokens_innodb ORDER BY RAND() LIMIT 0, 100;' | tail -n +2 > tokens.csv
