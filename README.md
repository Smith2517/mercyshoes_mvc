# Mercyshoes MVC (PHP + MySQL)

Tienda básica con carrito, checkout (comprobante HTML imprimible), descuento de stock e **cPanel** administrable.

## Requisitos
- XAMPP (PHP 8+, Apache, MySQL)
- Clonar/copiar esta carpeta dentro de `htdocs` como `mercyshoes_mvc`.

## Instalación
1. Importa `database.sql` en phpMyAdmin (crea la base `mercyshoes_db` y las tablas con datos demo).
2. Inicia Apache y MySQL en XAMPP.
3. Abre en el navegador: `http://localhost/mercyshoes_mvc/index.php`

## Accesos
- **cPanel**: `http://localhost/mercyshoes_mvc/index.php?r=admin/login`  
  Usuario: `admin@mercyshoes.local` • Clave: `admin123`

## Estructura MVC mínima
- `/app/controllers` — Controladores (`HomeController`, `ProductController`, `CartController`, `CheckoutController`, `AdminController`)
- `/app/models` — Modelos (`Product`, `Order`, `Category`, `User`, `Setting`)
- `/app/views` — Vistas (frontend y admin) + layouts
- `/core` — Núcleo (BD, base `Controller`, `Auth`)
- `/public` — CSS/JS/Uploads

## Flujo principal
- Catálogo → Carrito → Checkout → **Genera comprobante** (HTML imprimible) y **descuenta stock**.
- cPanel: ver/gestionar **Productos, Categorías, Pedidos, Reportes y Ajustes** (datos de la empresa).

## Subida de imágenes
- Se guardan en `/public/uploads`. Asegura permisos de escritura en esa carpeta.

## Personalización
- Modifica `config/config.php` para credenciales y BASE_URL si cambias el nombre de carpeta.
- Añade pasarela de pago real en `CheckoutController::pay()` si lo deseas.

> Este proyecto es un punto de partida **100% funcional** pensado para local (XAMPP). 
