# Proyecto: technical_test

## Descripción
Este proyecto es una aplicación PHP con MySQL que utiliza Docker para su despliegue. Incluye Doctrine como ORM para la gestión de la base de datos.

## Requisitos
Antes de comenzar, asegúrate de tener instalados los siguientes programas en tu sistema:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Make](https://www.gnu.org/software/make/)

## Instalación y Configuración
### 1. Clonar el repositorio
```sh
git clone https://github.com/6abr1elMR/technical_test.git
cd technical_test
```

### 2. Levantar los contenedores con Docker
Ejecuta el siguiente comando para construir y levantar los contenedores de la aplicación:
```sh
make up
```
Esto iniciará los contenedores definidos en `docker-compose.yml`.

### 3. Instalar dependencias de PHP
Una vez que los contenedores estén en ejecución, instala las dependencias con Composer:
```sh
make install-deps
```

### 4. Acceder a la terminal del contenedor PHP
Si necesitas ejecutar comandos dentro del contenedor de PHP, puedes abrir una terminal dentro de él con:
```sh
make shell-php
```

### 5. Acceder a la terminal del contenedor MySQL
Para acceder a la base de datos MySQL dentro del contenedor:
```sh
make shell-mysql
```

## Uso de Makefile
El `Makefile` contiene varios comandos útiles:

- **Iniciar el entorno:**
  ```sh
  make up
  ```
  Construye y levanta los contenedores de la aplicación.

- **Detener y eliminar los contenedores:**
  ```sh
  make down
  ```
  Detiene y elimina los contenedores.

- **Limpiar el entorno:**
  ```sh
  make clean
  ```
  Elimina volúmenes y limpia las imágenes de Docker.

- **Ver logs de PHP:**
  ```sh
  make logs-php
  ```

- **Ver logs de MySQL:**
  ```sh
  make logs-mysql
  ```

- **Ver estado de los contenedores:**
  ```sh
  make status
  ```
  Muestra una lista de los contenedores en ejecución.

## Apagar el entorno
Para detener los contenedores, ejecuta:
```sh
make down
```

Si necesitas eliminar volúmenes y limpiar las imágenes, usa:
```sh
make clean
```

---

Este README proporciona toda la información necesaria para poner en marcha el proyecto de forma rápida y eficiente. ¡Espero que te sea útil! 🚀

