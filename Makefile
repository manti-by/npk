build:
	docker build -t mantiby/apache-php-5-2:latest .

dump:
	docker exec -it npk-mysql mysqldump -u npk -ppa55word npk.of.by > data/database.sql
	sudo chown manti:manti data/database.sql

