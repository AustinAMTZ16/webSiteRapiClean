# 🧼 RapiClean - Venta en Línea

Este proyecto forma parte de la plataforma RapiClean, un servicio de lavandería que busca incursionar en el mercado digital. El objetivo de este módulo es permitir al cliente final realizar su pedido desde el sitio web de forma simple y segura.

## 🎯 Funcionalidades Principales

- Registro de clientes desde la web
- Visualización del catálogo de servicios
- Gestión de pedidos en línea
- Selección de métodos de pago: PayPal y Mercado Pago
- Almacenamiento de pedidos en el sistema actual

## 📁 Estructura del Proyecto
├───app
│   ├───config
│   ├───controllers
│   │   └───Prospectos
│   └───models
│       └───Prospectos
└───assets
    ├───css
    ├───img
    │   ├───logo-icon
    │   └───page
    └───js

## 🔧 Tecnologías Usadas

- HTML5 / CSS3 / JavaScript (vanilla)
- PHP 7.4+
- MySQL
- Fetch API para AJAX
- PayPal Smart Buttons: [docs](https://developer.paypal.com/docs/checkout/)
- Mercado Pago Checkout Pro: [docs](https://www.mercadopago.com.mx/developers/es/guides/payments/checkout-pro/introduction/)

## 💡 Consideraciones Técnicas

- Validación de formularios en frontend y backend
- Uso de `localStorage` para almacenar carrito
- Alertas visuales para una experiencia de usuario amigable
- Código responsivo y diseño limpio

## 🚧 Pendientes/Futuras Mejoras

- Seguimiento de pedidos por ID o correo
- Implementar historial de pedidos para clientes
- Mejora en control de stock e inventario



├── registro.html # Vista de registro de cliente
├── catalogo.html # Catálogo de servicios disponibles
├── pedido.html # Confirmación y método de pago
├── tiendaOnline.js # JS principal para el flujo web
├── php/
│ ├── registrarCliente.php # Backend para registro de clientes
│ ├── listaServicios.php # Backend para obtener servicios
│ └── registrarVenta.php # Backend para registrar pedidos