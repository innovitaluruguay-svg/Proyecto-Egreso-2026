# SIGSM - Prototipo (versión Bootstrap)

Prototipo de interfaz del Módulo Documentación.
No tiene lógica de backend todavía.

## Archivos

- `index.html` -> menú para moverse entre las pantallas
- `login.html` -> inicio de sesión
- `admin-documentos.html` -> panel de administración (tabla + modal para cargar documento)
- `documento-qr.html` -> lo que ve el paciente al escanear el QR
- `encuesta.html` -> encuesta de satisfacción
- `assets/css/estilos.css` -> nuestros ajustes propios, aparte de Bootstrap

## Cómo verlo

Abrir `index.html` con doble clic, o hacer clic derecho -> "Abrir con" -> el navegador.
No hace falta instalar nada: Bootstrap se carga desde internet (CDN) con estas líneas
que están en el `<head>` de cada página:

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

## Cómo se arma cada página (para poder explicarla)

- `container` + `row` + `col-*`: es la grilla de Bootstrap, ordena todo en columnas
  que se acomodan solas según el tamaño de pantalla (celular, tablet, PC).
- `card`: la "caja" blanca con sombra que se usa para agrupar contenido.
- `btn`, `btn-primary`, `btn-outline-secondary`: estilos de botones ya hechos.
- `navbar`: la barra de arriba, con el menú que se convierte en hamburguesa en celular.
- `table`, `table-striped`: la tabla de documentos, con filas alternadas.
- `modal`: la ventanita que aparece al apretar "Nuevo documento" (no hace falta
  programarla, ya viene lista en Bootstrap con los atributos `data-bs-toggle`
  y `data-bs-target`).
- `form-control`, `form-select`, `form-check`: los campos de los formularios.
- `badge`: las etiquetas de color (Publicado, Borrador, etc.)


