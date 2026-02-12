# Gestión de Alumnos y Notas (PHP CRUD)

Sistema CRUD en PHP + MySQL para registrar alumnos y sus notas, calcular promedios y generar reportes en **PDF** y **Excel**.

## Funcionalidades
- CRUD de Alumnos (crear, listar, editar, eliminar)
- Registro de Notas por alumno
- Cálculo de promedio y resultado cualitativo
- Reporte en PDF (dompdf)
- Reporte en Excel (PhpSpreadsheet)

## Tecnologías
- PHP 8+
- MySQL (phpMyAdmin)
- HTML + CSS (Bootstrap + assets/css)
- Composer (dependencias)
- dompdf (PDF)
- phpoffice/phpspreadsheet (Excel)

## Estructura del proyecto (resumen)
- `public/` → páginas (index.php, alumno_create.php, reporte_pdf.php, reporte_excel.php, etc.)
- `config/` → conexión a BD (`db.php`)
- `helpers/` → funciones auxiliares
- `assets/css/` → estilos propios
- `composer.json` y `composer.lock` → dependencias
- `vendor/` → se genera con Composer (NO es obligatorio subirlo a GitHub)

## Requisitos
- XAMPP (Apache + MySQL)
- PHP 8+
- Composer instalado

## Instalación (paso a paso)
1. Clonar o copiar el proyecto dentro de:
   `C:\xampp\htdocs\gestion_notas`

2. Encender XAMPP:
   - Start **Apache**
   - Start **MySQL**

3. Crear la base de datos en phpMyAdmin:
   - Nombre: `academico_php` (o el que estés usando)
   - Importar el archivo SQL: `schema.sql` (o el archivo que tengas)

4. Configurar la conexión a BD:
   - Archivo: `config/db.php`
   - Revisar usuario/clave/puerto/nombre de BD

5. Instalar dependencias (Composer):
   Abrir CMD en la raíz del proyecto y ejecutar:
   ```bash
   composer install
