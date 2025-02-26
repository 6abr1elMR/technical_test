PROJECT_NAME=docker_php_mysql

DCOMPOSE=docker-compose

up:
	@echo "🚀 Iniciando el entorno..."
	$(DCOMPOSE) up -d --build

down:
	@echo "🛑 Deteniendo y eliminando contenedores..."
	$(DCOMPOSE) down

clean:
	@echo "🧹 Limpiando el entorno..."
	$(DCOMPOSE) down -v
	docker rmi -f $$(docker images -q) || true
	docker system prune -f

logs-php:
	@echo "📜 Mostrando logs de PHP..."
	docker logs -f php_app

logs-mysql:
	@echo "📜 Mostrando logs de MySQL..."
	docker logs -f mysql

shell-php:
	@echo "💻 Abriendo terminal en el contenedor PHP..."
	docker exec -it php_app bash

shell-mysql:
	@echo "💻 Abriendo terminal en el contenedor MySQL..."
	docker exec -it mysql bash

status:
	@echo "🔍 Contenedores en ejecución:"
	docker ps

install-deps:
	@echo "📦 Instalando dependencias PHP con Composer..."
	docker exec -it php_app composer install
