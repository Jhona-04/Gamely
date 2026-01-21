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
  
---

## 📁 Estructura del proyecto (boceto)

```
/gamely
│
├── /database
│   ├── /config
│   │   └── database.php          # Configuración de la base de datos
│   └── /schemas
│       └── schema.php            # Estructura de tablas
│
├── /src
│   ├── /assets
│   │   ├── /css
│   │   │   ├── carrito
│   │   │   │   └── carrito.css   # Estilos del carrito
│   │   │   ├── catalogo
│   │   │   │   └── catalogo.css  # Estilos del catálogo
│   │   │   ├── footer.css
│   │   │   ├── header.css
│   │   │   ├── menu.css
│   │   │   └── style.css
│   │   └── /images                 # Imágenes del sitio
│   │
│   ├── /functions
│   │   └── funciones.php           # Funciones reutilizables
│   │
│   └── /public
│       ├── carrito.php
│       ├── catalogo.php
│       ├── index.php
│       └── registro.php
│
├── README.md   
