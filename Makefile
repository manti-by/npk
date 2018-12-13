dump:
	docker exec -it npk-mysql mysqldump -u npk -ppa55word npk.of.by > deploy/database/database.sql
	sudo chown manti:manti deploy/database/database.sql