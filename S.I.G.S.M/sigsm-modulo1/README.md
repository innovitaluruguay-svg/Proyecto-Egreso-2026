# SIGSM - Módulo 1

Sistema de gestión de documentación y encuestas para pacientes.

## Tecnologías
- PHP 8.x
- MySQL/MariaDB
- Bootstrap 5.3
- HTML/CSS/JavaScript
- XAMPP para desarrollo local
- Ubuntu Server + Apache/Nginx para producción, según DTI

## Estructura
- `admin/`: panel administrativo.
- `paciente/`: portal público.
- `config/`: configuración, sesión y conexión.
- `database/`: scripts SQL.
- `public/storage/documentos/`: PDFs publicados.

## Instalación en XAMPP
1. Copiar la carpeta del proyecto a `C:\xampp\htdocs\`.
2. Encender Apache y MySQL.
3. Abrir `http://localhost/phpmyadmin`.
4. Importar `database/schema.sql` en una instalación nueva.
5. Configurar en `config/database.php` la contraseña del usuario `sigsm_app`.
6. Abrir `admin/crear_admin.php` y crear el primer administrador.
7. Borrar `admin/crear_admin.php` después de crear el usuario.
8. Entrar a `admin/login.php`.
9. Portal paciente: `paciente/home.php`.


## Usuario de MySQL
La aplicación utiliza `sigsm_app` y no `root`.
`root` queda para administrar MySQL/phpMyAdmin.

## Código QR
Cada documento tiene una opción `QR` en el panel administrativo.

El QR contiene un enlace directo a:
`paciente/documento.php?id=...`

### Probar el QR desde un celular
El celular y la PC deben estar conectados a la misma red Wi-Fi.

1. En Windows ejecute `ipconfig`.
2. Busque la `Dirección IPv4` de la PC.
3. Abra SIGSM desde la PC usando esa dirección, por ejemplo:
   `http://192.168.1.25/sigsmm1`
4. En `config/config.php` puede dejar `$URL_PUBLICA = ''` para usar automáticamente la dirección con la que abrió el sistema.
5. Si desea fijar una dirección, coloque:
   `$URL_PUBLICA = 'http://192.168.1.25/sigsmm1';`
6. Genere el QR desde `Admin > Documentos > QR`.
7. Escanéelo desde el celular.

Si no funciona desde el celular, revise el Firewall de Windows y que la red permita que los dispositivos se comuniquen entre sí.

### QR en producción
No se recomienda exponer un XAMPP personal mediante port forwarding del router para un sistema hospitalario.
En el servidor del DTI se deberá definir la URL pública, HTTPS y las reglas de red correspondientes.

## .htaccess
Los archivos `.htaccess` se utilizan para bloquear el acceso directo a carpetas sensibles.
Esta protección depende de que Apache permita `AllowOverride` para el directorio. Si DTI usa `AllowOverride None`, habrá que aplicar la misma restricción mediante la configuración del servidor.

## Seguridad básica
- `password_hash()` y `password_verify()`.
- Sesiones PHP y control de roles.
- CSRF en formularios administrativos.
- Consultas preparadas con PDO.
- Validación de PDFs y límite de 10 MB.
- Usuario MySQL con permisos limitados.
- Registro de auditoría.

## Requisitos del curso
El proyecto incluye login, cierre de sesión, sesiones, dos roles, panel administrativo, alta/listado/edición/eliminación lógica de documentos, categorías, vista pública, QR y diseño responsive.


## Documentos
Los documentos mantienen solamente el archivo actual. El módulo no utiliza historial de versiones.
