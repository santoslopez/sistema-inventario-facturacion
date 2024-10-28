# SISTEMAS DE FACTURACION, VENTAS Y CONTROL DE INVENTARIO
La finalidad es tener un control de las ventas, generar reportes de compras,
reportes de ventas, facturas anuladas, tener un reporte de inventario actual, etc. Algunas funcionalidades no fueron colocadas de forma explícita. La versión del README actual podría no estar actualiza.

El software fue realizado en PHP, POSTGRESQL, Boostrap, Html, Css, transacciones en base de datos, etc. 

## PROVEEDOR:
- Agrega, busca, validar nit en uso, elimina, modifica, pagina, muestra mensaje de confirmacion al eliminar.

## PROVEEDOR:
- Agrega, busca, elimina, pagina, muestra mensaje de confirmacion al eliminar

## LOGIN
- Verifica inicio de sesion con ajax 
- Bloquea archivos php y html usando .htaccess
- Desactiva boton de login al enviar datos

### Empresa
- Registra empresa, 
- Modifica excepto el nit de empresa.
- Carga los datos para editar empresa y 

### USUARIO ADMINISTRADOR
- Se bloquea el boton para eliminar al administrador.

### PRODUCTOS
- Crear productos, pagina, lista
- Modifica productos, pero no modifica el codigo de producto
- Elimina productos
- Verifica que el producto no este en uso

### COMPRAS DE PRODUCTOS / FACTURA COMPRA
- Crear un documento con los detalles basicos de la factura de compra
- Elimina la factura
- Busca y pagina datos
- Agrega productos en la factura de compra correctamente.
- Muestra total de la factura de compra
- Muestra productos agregados en factura de compra correctamente.
- Actualiza compra de productos en factura
- Evitar que se repita el producto en la tabla de compras en factura

### CLIENTES
- Cliente con c/f deja guardar los datos
- Dejar guardar clientes con NIT existente, excepto C/f con transaccion

### OTROS REALIZADOS
- No muestra archivos sino se ha iniciado sesion
- Procedimiento almacenado para agregar productos, clientes y proveedores
- Transaccion en registro de productos, verifica sino esta en uso primero antes de insertar
 
### VENTAS
- Quitar mensaje de alerta menor precio a compra
- Aparentemente vende si el stock es vacio, pero no resta (esto esta bien)
- Muestra mensaje que estas a punto de vender
- Hace el insert en factura de cliente sino hay stock pero no lo pone en detalle de factura cliente (bien)