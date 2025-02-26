# Guía de Instalación y Ejecución del Proyecto

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalados los siguientes componentes en tu sistema:

- **Docker**: Para la creación y gestión de contenedores.
- **Docker Compose**: Para orquestar los contenedores de Docker.
- **Composer**: Para gestionar las dependencias de PHP.

## Pasos para Configurar y Ejecutar el Proyecto

### 1. Clonar el Repositorio

Abre una terminal y ejecuta:

```bash
git clone https://github.com/6abr1elMR/technical_test.git
cd technical_test
```

### 2. Instalar Dependencias de PHP

Utiliza Composer para instalar las dependencias necesarias:

```bash
composer install
```

### 3. Levantar los Contenedores con Docker Compose

Inicia los servicios definidos en el archivo `docker-compose.yml`:

```bash
docker-compose up -d
```

Esto levantará los contenedores en segundo plano.

### 4. Inicializar la Base de Datos

Una vez que los contenedores estén en funcionamiento, ejecuta las migraciones para crear las tablas necesarias en la base 
de datos:

```bash
docker-compose exec app php vendor/bin/doctrine-migrations migrate
```

Este comando se ejecuta dentro del contenedor `app` y aplica las migraciones de Doctrine.

### 5. Verificar el Funcionamiento

Después de completar los pasos anteriores, el proyecto debería estar en funcionamiento. Puedes verificar accediendo a 
`http://localhost` en tu navegador web o utilizando herramientas como `curl` o `Postman` para realizar solicitudes HTTP.

## Estructura del Proyecto

El proyecto tiene la siguiente estructura de directorios y archivos:

```
technical_test/
├── src/                  # Código fuente de la aplicación
├── tests/                # Pruebas unitarias y funcionales
├── docker-compose.yml    # Configuración de Docker Compose
├── Makefile              # Comandos útiles para la gestión del proyecto
├── composer.json         # Dependencias del proyecto
└── README.md             # Documentación del proyecto
```

## Comandos ÚTiles

- **Construir los Contenedores**:

  ```bash
  docker-compose build
  ```

- **Detener los Contenedores**:

  ```bash
  docker-compose down
  ```

- **Ejecutar Pruebas**:

  ```bash
  docker-compose exec app vendor/bin/phpunit
  ```

  Este comando ejecuta las pruebas definidas en el directorio `tests/`.

## Notas Adicionales

- **Configuración de la Base de Datos**: Asegúrate de que los parámetros de conexión a la base de datos en el archivo de 
configuración coincidan con los definidos en `docker-compose.yml`.

- **Variables de Entorno**: Si es necesario, crea un archivo `.env` en la raíz del proyecto para definir variables de 
entorno específicas.

Para más detalles y posibles actualizaciones, consulta el repositorio oficial del proyecto en 
[https://github.com/6abr1elMR/technical_test](https://github.com/6abr1elMR/technical_test).

---

¡Espero que esta guía te sea útil para poner en marcha el proyecto! 🚀
