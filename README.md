#  Sistema Web de Registro de Visitantes  
## Hotel Bogotá Plaza

Sistema web desarrollado para registrar, consultar y exportar el control de ingreso y salida de visitantes, proveedores y contratistas en el Hotel Bogotá Plaza.

---

##  Funcionalidades principales

✅ Formulario responsivo (PC, celular, tablet)  
✅ Registro en base de datos MySQL  
✅ Visualización tipo tabla (`listar.php`)  
✅ Exportar a Excel (.xls)  
✅ Exportar a PDF (modo horizontal, optimizado)  
✅ Logo institucional y estilo verde corporativo  
✅ Lista de destinos + campo "Otro"  
✅ Campo adicional: ¿Quién autoriza el ingreso?

---

## 🧰 Tecnologías utilizadas

| Tecnología       | Uso                              |
|------------------|----------------------------------|
| **HTML + CSS**   | Maquetación del formulario       |
| **Bootstrap 5**  | Diseño responsivo                |
| **PHP**          | Backend / conexión a base de datos |
| **MySQL**        | Almacenamiento de registros      |
| **phpMyAdmin**   | Gestión de base de datos         |
| **JavaScript**   | Campos condicionales             |
| **Git + GitHub** | Control de versiones y hosting   |

---

## 📁 Estructura del proyecto
📦 Registro_Visitantes_Hotel_Bogota_Plaza/
├── frontend/
│ └── index.html
├── backend/
│ ├── registro.php
│ ├── listar.php
│ └── exportar.php
├── assets/
│ └── logo.png
├── documentacion_proyecto.xt
└── README.md

---

## 🚀 Cómo ejecutar el proyecto localmente

1. Instala **XAMPP** y activa Apache + MySQL  
2. Copia el proyecto a:  
   `C:/xampp/htdocs/Registro_Visitantes_Hotel_Bogota_Plaza/`
3. Crea la base de datos `registro_visitantes` desde phpMyAdmin  
4. Crea la tabla `visitantes` con los campos correspondientes  
5. Accede desde tu navegador:  
   `http://localhost/Registro_Visitantes_Hotel_Bogota_Plaza/frontend/index.html`

---

## 📤 Exportar registros

- Excel → botón “📥 Exportar a Excel”
- PDF → botón “🧾 Exportar a PDF”  
  (⚠️ Recuerda elegir orientación horizontal al imprimir)

---

## 📱 Accesibilidad multiplataforma

Este sistema funciona correctamente en:

- 💻 Computadores y portátiles
- 📱 Dispositivos móviles
- 📲 Tablets

Gracias a Bootstrap, todo el diseño es completamente adaptativo.

---

## 👤 Autor

**Hernando Vega**  
Estudiante de Ingeniería de Sistemas  
Corporación Universitaria Minuto de Dios – UNIMINUTO  
Bogotá, 2025

