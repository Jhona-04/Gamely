# Gamely 🎮  
**Tienda Online de Videojuegos**

## 📌 Descripción del proyecto
**Gamely** es una tienda online de videojuegos que permitirá a los usuarios **explorar, comprar y gestionar videojuegos** de forma sencilla y segura.  
El proyecto tiene como objetivo desarrollar una plataforma web funcional que simule el funcionamiento real de una tienda digital, aplicando buenas prácticas de desarrollo web en entorno servidor.

Este proyecto se desarrolla como parte de la asignatura **Desarrollo Web en Entorno Servidor (DWES)**, siguiendo requisitos académicos y criterios orientados a un producto real para cliente.

---

## 🎯 Objetivos
- Crear una tienda online de videojuegos funcional
- Implementar un sistema de **registro y login de usuarios**
- Gestionar productos (videojuegos)
- Simular un proceso de compra
- Aplicar conceptos básicos de seguridad y bases de datos

---

## 🛠️ Tecnologías utilizadas
- HTML5
- CSS3
- PHP (mysqli)
- MySQL
- Servidor local (XAMPP / WAMP / MAMP)

---

## 🧠 Resumen 
- Solo usuarios registrados pueden acceder a Gamely

- El Administrador gestiona la tienda

- El Cliente compra videojuegos y gestiona su cuenta

```
/gamely
│
├── /assets
│ ├── /css # Estilos CSS
│ ├── /images # Imágenes del sitio
│
├── /config
│ └── database.php # Conexión bdd
│
├── /funcionts
│ └── funciones.php # Funciones reutilizables
│
├── /public
│ └── carrito.php # Carrito de compra
│ ├── catalogo.php # Lista de videojuegos
│ ├── index.php # Página principal
│ ├── login.php # Login de usuarios
│ ├── registro.php # Registro de usuarios
│
└── README.md