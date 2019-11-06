# canae-adoc-light
Propuesta ligera de aplicación web de documentación para las asambleas de Canae Confederación Estatal de Asociaciones de Estudiantes, con vistas a una futura ampliación de servicios y capacidad.

## Instalación
1. Ubicar los archivos en el directorio correspondiente del servidor.
2. Editar el archivo `sys/main.php` para adaptar las configuraciones de MySQL y de información.
3. Crear las tablas en la base de datos mediante las siguientes operaciones:

```mysql
CREATE TABLE `adoc_documents` (
  `document_id` int(16) NOT NULL AUTO_INCREMENT,
  `document_title` varchar(256) NOT NULL,
  `document_description` text NOT NULL,
  `document_mime` varchar(256) NOT NULL,
  `document_file_path` varchar(256) NOT NULL,
  `document_file_name` varchar(256) NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

CREATE TABLE `adoc_users` (
  `user_id` int(16) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(256) NOT NULL,
  `user_email` varchar(256) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_is_admin` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
```

4. Crear un usuario manualmente en la base de datos.
