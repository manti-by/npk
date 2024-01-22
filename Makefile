start:
	docker compose -f deploy/docker-compose.yml up -d

stop:
	docker compose -f deploy/docker-compose.yml stop

destroy:
	docker compose -f deploy/docker-compose.yml down

dump:
	docker exec -it npk-mysql mysqldump -u npk -ppa55word npk.of.by > deploy/database/database.sql
	sudo chown manti:manti deploy/database/database.sql
