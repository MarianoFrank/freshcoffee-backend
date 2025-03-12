
# Laravel Backend Project

Este es el backend del proyecto desarrollado con Laravel, diseñado para correr en un entorno Docker con Laravel Sail. Sigue los pasos a continuación para configurar el entorno y comenzar.

Aqui puede encontrar el FRONTEND hecho en REACT ⚛️: https://github.com/MarianoFrank/freshcoffee-frontend

## Requisitos previos

- Tener Docker y Docker Compose instalados en tu sistema.
- Asegurarte de que tienes `git` instalado para clonar el repositorio.

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DEL_PROYECTO>
```

### 2. Instalar dependencias

Ejecuta el siguiente comando para instalar las dependencias del proyecto utilizando Laravel Sail:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Configurar el entorno

Copia el archivo `.env.example` y renómbralo a `.env`:

```bash
cp .env.example .env
```

Completa las variables en el archivo `.env` según sea necesario, especialmente aquellas relacionadas con la base de datos y servicios adicionales.

### 4. Iniciar el entorno de desarrollo

Ejecuta Laravel Sail para levantar el entorno:

```bash
./vendor/bin/sail up -d
```

### 5. Servicios adicionales

En dos terminales separadas, inicia los siguientes servicios:

#### Iniciar el servidor de broadcasting:

```bash
#solo para depurar los eventos lanzados
./vendor/bin/sail artisan reverb:start  
```

#### Iniciar el sistema de colas:

```bash
#para procesar los eventos y para el broadcasting
./vendor/bin/sail artisan queue:work
```

---

## Comandos útiles

- **Detener el entorno:**  
  ```bash
  ./vendor/bin/sail down
  ```

- **Revisar los logs:**  
  ```bash
  ./vendor/bin/sail logs
  ```

---
