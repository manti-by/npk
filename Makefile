start:
	@docker-compose -f deploy/docker-compose.yml up -d
	@printf "Waiting for MySQL."
	@until docker exec -it npk-mysql mysql -u npk -ppa55word -e 'show databases;' > /dev/null; do printf "."; sleep 1; done
	@printf " Connected!\n"

stop:
	@docker-compose -f deploy/docker-compose.yml stop

destroy:
	@docker-compose -f deploy/docker-compose.yml down

dump:
	docker exec -it npk-mysql mysqldump -u npk -ppa55word npk.of.by > deploy/database/database.sql
	sudo chown manti:manti deploy/database/database.sql