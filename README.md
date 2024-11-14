# Sistema control de inventario, facturación, reportes, compras, ventas, etc.
Software para el control de inventario empresarial desarrollado con PHP como lenguaje de programación y PostgreSql como motor de base de datos relacional. Durante la implementación del proyecto se utilizaron diversas técnicas de seguridad, como transacciones en la base de datos para evitar pérdida de datos en caso de fallos (ROLLBACK), funciones de seguridad en sesiones, medidas anti-inyección SQL y scripts, encriptación de contraseñas, así como tecnologías web como Ajax, JavaScript, Bootstrap y CSS.

La utilización de transacciones en las funciones permite asegurar que en caso de que ocurra un error inesperado (como un corte de energía), la base de datos se restablezca a su estado anterior (ROLLBACK) y que, si la operación se realiza correctamente, se guarden los cambios de manera permanente (COMMIT).

## <code>Realizar ventas, resumen de ventas y clientes</code>
La siguiente imagen corresponde a la interfaz en donde se muestrán los botones para realizar ventas, resumen de ventas y clientes.
[![Opción ventas](https://santoslopez.github.io/assets/posts/software-inventario/1.webp)](https://santoslopez.github.io/assets/posts/software-inventario/1.webp)

## <code>Resumen de ventas</code>
Está opción muestra por defecto las ventas generadas en el día, sin embargo si es necesario mostrar el reporte de días anteriores se filtra los resultados por medio de un fecha de inicio y una fecha fin. En la tabla está un enlace para ver los detalles (cantidad vendido, precio vendido, descripción, etc) de los comprobantes o facturas de ventas. 

En la tabla hay una opción para anular la factura de venta, al realizar esto el inventario se actualiza nuevamente. El botón de anular factura solo aparece en los primeros 6 meses a partir de la fecha de venta. 
[![Resumen de ventas hoy](https://santoslopez.github.io/assets/posts/software-inventario/6.webp)](https://santoslopez.github.io/assets/posts/software-inventario/6.webp)

## <code>Anular factura de venta</code>
Al proceder a anular la factura de venta se muestra un mensaje para confirmar que se desea proceder con la acción. Al confirmar la anulación de factura también se actualiza nuevamente el inventario.
[![Anular venta](https://santoslopez.github.io/assets/posts/software-inventario/8.webp)](https://santoslopez.github.io/assets/posts/software-inventario/8.webp)

## <code>Realizar ventas</code>
Para generar una venta se busca el nit del cliente, en caso que el cliente no posee está información el sistema permite que se utilice "c.f". En buscar producto se ingresa el código del producto, al ingresar el código de forma automática se realiza una búsqueda para cargar los resultados en descripción. 

El sistema valida que la cantidad a vender no sea mayor a la cantidad de productos que hay en existencia en el inventario. 
[![Realizar comprobante de ventas](https://santoslopez.github.io/assets/posts/software-inventario/5.webp)](https://santoslopez.github.io/assets/posts/software-inventario/5.webp)

[![Generar reporte de compras](https://santoslopez.github.io/assets/posts/software-inventario/3.webp)](https://santoslopez.github.io/assets/posts/software-inventario/3.webp)

## <code>Productos, Stock de productos y reporte de inventario</code>
En está interfaz se muestra al usuario 3 botones: mis productos, stock de productos y reporte de inventario. 
[![Productos](https://santoslopez.github.io/assets/posts/software-inventario/4.webp)](https://santoslopez.github.io/assets/posts/software-inventario/4.webp)

## <code>Realizar compras, reporte de compras y proveedores</code>
La siguiente imagen muestra los botones para realizar compras, generar reporte de compras y acceder proveedores para agregar, modificar o eliminar datos. 
[![Opción de compras](https://santoslopez.github.io/assets/posts/software-inventario/2.webp)](https://santoslopez.github.io/assets/posts/software-inventario/2.webp)
