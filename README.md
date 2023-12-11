# Audiora :notes:

## Proyecto semestral de Ingenieria web y Mantenimiento de Software. :computer:

## Integrantes:

- _Alejandro González_
- _Alfonso Rodríguez_
- _Jordy Rosales_
- _Nicole Valdés_

## Grupo: 1SF133

## UTP II SEMESTRE 2023

# Configuración del Proyecto y la Base de Datos en XAMPP

## Requisitos previos

- Asegúrate de tener instalado XAMPP en tu máquina.
- Clonar o Descargar el Repositorio

## Clona el repositorio desde GitHub

`git clone https://github.com/tu-usuario/tu-proyecto.git`

## O descarga el ZIP y extrae el contenido en tu directorio htdocs

`https://github.com/tu-usuario/tu-proyecto/archive/main.zip`

# Configurar la Base de Datos

- Abre XAMPP y asegúrate de que Apache y MySQL estén iniciados.

- Accede a http://localhost/phpmyadmin/ en tu navegador.

- En la interfaz de phpMyAdmin, crea una nueva base de datos llamada audiora.

- Selecciona la nueva base de datos y ve a la pestaña "Importar".

- Haz clic en "Examinar" y selecciona el archivo SQL de tu proyecto (generalmente ubicado en db/audiora.sql).

- Haz clic en "Continuar" para importar la estructura y los datos a la base de datos audiora.

- Configurar el Proyecto

- Abre tu navegador y ve a http://localhost/tu-proyecto/.

## ¡Listo! Ahora deberías ver tu proyecto en ejecución.

> Debes aumentar el valor de max_allowed_packet en la configuración de MySQL.

Sigue estos pasos:

- Abre el archivo de configuración de MySQL (my.ini o my.cnf). Puedes encontrar este archivo en el directorio de configuración de MySQL.

- Encuentra la sección [mysqld] en el archivo.

- Agrega o modifica la siguiente línea para aumentar el valor de max_allowed_packet. Por ejemplo:

`max_allowed_packet = 128M`
- Ajusta el valor (128M en este ejemplo) según tus necesidades y la cantidad de datos que esperas manejar.

- Guarda el archivo y reinicia el servidor MySQL para que los cambios surtan efecto.
