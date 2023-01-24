CREATE TABLE Rol(
    codRol serial NOT NULL,
    nombreRol varchar(20) NOT NULL,
    PRIMARY KEY (codRol)
);

INSERT INTO Rol(codRol,nombreRol) VALUES(1,'admin');
INSERT INTO Rol(codRol,nombreRol) VALUES(2,'cajero');

CREATE TABLE Usuarios(
    codigoUsuario serial NOT NULL,
    correo varchar(50) NOT NULL,
    estado CHAR(1) CHECK(estado='A' OR estado='I') NOT NULL,
    fechaRegistro date NOT NULL,
    nombreApellidos varchar (100) NOT NULL,
    contrasena varchar(255) NOT NULL,
    codRol int NOT NULL,
    PRIMARY KEY (codigoUsuario),
    CONSTRAINT PK_ROL_USUARIOS FOREIGN KEY (codRol) REFERENCES Rol(codRol)  
);

INSERT INTO Usuarios(correo,estado,fechaRegistro,nombreApellidos,contrasena,codRol) VALUES('lopeztsantos@gmail.com','A','2022-07-19','Santos Lopez','$2y$10$P4ZVyPyVWmkdpGBvtPd6fOslsqrwvHn9raG1kKR/QKmnVsd/2kaJa',1);

CREATE TABLE Productos(
    codigoProducto varchar(30) NOT NULL,
    descripcion varchar(150) NOT NULL,
    foto varchar(100) NOT NULL DEFAULT 'profile.png',
    PRIMARY KEY (codigoProducto)
);

CREATE OR REPLACE FUNCTION PA_eliminarProducto(buscarCodigoProducto varchar(30)) RETURNS varchar AS

$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from Productos WHERE (codigoProducto=buscarCodigoProducto)) > 0 THEN
            DELETE FROM Productos WHERE codigoProducto=buscarCodigoProducto;
            return 'productoeliminado';
            COMMIT;
        ELSE
            return 'productonoexiste';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;       
       
    END;
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION PA_modificarProductos(buscarCodigoProducto varchar(30),nuevaDescripcionEmpresa varchar(150)) RETURNS varchar AS
$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from  Productos WHERE (codigoProducto=buscarCodigoProducto)) > 0 THEN
            UPDATE Productos SET descripcion=nuevaDescripcionEmpresa WHERE codigoProducto=buscarCodigoProducto;
            return 'productoactualizado';
            COMMIT;
        ELSE
            return 'productonoexiste';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;       
    END;
$$ LANGUAGE 'plpgsql';

CREATE TABLE Empresas(
    nitEmpresa varchar(20) NOT NULL,
    nombre varchar(100) NOT NULL,
    direccion varchar(100) NOT NULL,
    logoEmpresa varchar(100) NOT NULL DEFAULT 'profile.png',
    codigoUsuario int NOT NULL,
    PRIMARY KEY (nitEmpresa),
    CONSTRAINT PK_USUARIOS_EMPRESAS FOREIGN KEY (codigoUsuario) REFERENCES Usuarios(codigoUsuario)  
 );

CREATE TABLE Proveedor(
    nitProveedor varchar(20) NOT NULL,
    nombreEmpresa varchar(60) NOT NULL,
    logo varchar(100),
    direccion varchar(100) NOT NULL,
    telefono varchar(15) NOT NULL,
    PRIMARY KEY (nitProveedor)
);

CREATE OR REPLACE FUNCTION PA_modificarProveedor(buscarNitProveedor varchar(20),datosEmpresa varchar(60),
                                                datosDireccion varchar(100),datosTelefono varchar(15)) RETURNS varchar AS
$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from  Proveedor WHERE (nitproveedor=buscarNitProveedor)) > 0 THEN
            UPDATE Proveedor SET nombreEmpresa=datosEmpresa,direccion=datosDireccion,telefono=datosTelefono WHERE nitproveedor=buscarNitProveedor;
            return 'proveedoractualizado';
            COMMIT;
        ELSE
            return 'proveedornoexiste';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;       
    END;
$$ LANGUAGE 'plpgsql';

CREATE TABLE Clientes(
    codigoCliente SERIAL NOT NULL,
    nombreApellidos varchar(100) NOT NULL,
    direccion varchar(50) NOT NULL,
    nitCliente varchar(20) NOT NULL,
    telefono varchar(15),
    PRIMARY KEY (codigoCliente)
);

CREATE TABLE FacturaCompra(
    numeroDocumento SERIAL NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    fechaRegistro date NOT NULL,
    fechaFacturaProveedor  date NOT NULL,
    nitProveedor varchar(20) NOT NULL,
    estado CHAR(1) CHECK(estado='P' OR estado='A' OR estado='N') NOT NULL,
    PRIMARY KEY (documentoProveedor),
    CONSTRAINT PK_FacturaCompra_NitProveedor FOREIGN KEY (nitProveedor) REFERENCES Proveedor(nitProveedor )  
);


CREATE TABLE DetalleFacturaCompra(
    idDetalle SERIAL NOT NULL,
    precioCompra decimal(10,2) NOT NULL CHECK(precioCompra >= 0),
    cantidadComprado int NOT NULL CHECK(cantidadComprado > 0),
    codigoProducto varchar(50) NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    estado CHAR(1) CHECK(estado='P' OR estado='A' OR estado='N') NOT NULL,
    PRIMARY KEY (idDetalle),
    CONSTRAINT PK_DetalleFacturaCompra FOREIGN KEY (documentoProveedor) REFERENCES FacturaCompra(documentoProveedor),  
    CONSTRAINT PK_Producto_Detalle FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)  
);

CREATE TABLE FacturaVenta(
    numeroDocumentoFacturaVenta SERIAL NOT NULL,
    codigoCliente int NOT NULL,
    totalVenta float NOT NULL,
    fechaFacturaVenta date NOT NULL,
    horaVenta time NOT NULL,
    estado CHAR(1) CHECK(estado='P' OR estado='A') NOT NULL,
    codigoUsuario int NOT NULL,
    detalle1 varchar(100) NOT NULL,
    detalle2 varchar(100) NOT NULL,
    PRIMARY KEY (numeroDocumentoFacturaVenta),
    CONSTRAINT PK_FacturaVentaCliente FOREIGN KEY (codigoCliente) REFERENCES Clientes(codigoCliente),
    FOREIGN KEY (codigoUsuario) REFERENCES Usuarios(codigoUsuario)
);

CREATE TABLE DetalleFacturaVenta(
    idDetalle SERIAL NOT NULL,
    codigoProducto varchar(50) NOT NULL,
    cantidadComprado int NOT NULL CHECK(cantidadComprado > 0),
    precioCompra decimal(10,2) NOT NULL CHECK(precioCompra >= 0),
    numeroDocumentoFacturaVenta int NOT NULL,
    PRIMARY KEY (idDetalle),
    CONSTRAINT PK_DetalleFacturaVenta FOREIGN KEY (numeroDocumentoFacturaVenta) REFERENCES FacturaVenta(numeroDocumentoFacturaVenta),  
    CONSTRAINT PK_Producto_Detalle FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)
);

CREATE TABLE EnvioTransporte(
    codigoEmpresa SERIAL NOT NULL,
    nitEmpresa varchar(20) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    direccion VARCHAR(50) NOT NULL, 
    telefono VARCHAR(15),
    PRIMARY KEY (codigoEmpresa)
);

CREATE TABLE Inventario(
    codInventario SERIAL NOT NULL,
    codigoProducto varchar(50) NOT NULL,
    cantidadComprado int NOT NULL CHECK(cantidadComprado >= 0),
    precioCompra decimal(10,2) NOT NULL CHECK(precioCompra >= 0),
    PRIMARY KEY (codInventario),
    CONSTRAINT PK_DetalleProductoCompra FOREIGN KEY (codigoProducto) 
    REFERENCES Productos(codigoProducto)  
);

CREATE OR REPLACE FUNCTION PA_insertarProducto(productoCod  varchar(50), nombreProducto varchar(100), fotoProducto varchar(100)) RETURNS varchar AS 
$$
    DECLARE
    BEGIN
        IF (SELECT count(*) from Productos WHERE codigoProducto=productoCod) > 0 THEN
            return 'enuso';
        ELSE
            INSERT INTO Productos VALUES (productoCod,nombreProducto,fotoProducto);
            return 'registrado';
            COMMIT;
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION PA_registrarProveedor(proveedorNit varchar(20), empresaNombre varchar(60), logoEmpresa varchar(100), direccionEmpresa varchar(100), telefonoEmpresa varchar(15)) RETURNS VARCHAR AS 
$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from Proveedor WHERE nitProveedor=proveedorNit) > 0 THEN
            return 'enuso';
        ELSE
            INSERT INTO Proveedor VALUES (proveedorNit,empresaNombre,logoEmpresa,direccionEmpresa,telefonoEmpresa);
            return 'registrado';
            COMMIT;
        END IF;

    Exception 
        
        When others then 
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_insertarCliente(nombreA varchar(100),direc varchar(50),nitC varchar(20),tele varchar(15)) RETURNS varchar AS 
$$
    DECLARE
    BEGIN
        IF (SELECT count(*) from Clientes WHERE (nitCliente=nitC) AND (nitCliente!='c.f')) > 0 THEN
            return 'enuso';            
        ELSE        
            INSERT INTO Clientes (nombreApellidos,direccion,nitCliente,telefono) VALUES (nombreA,direc,nitC,tele);
            return 'registrado';
            COMMIT;
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_eliminarProveedor(buscarNitProveedor varchar(20)) RETURNS varchar AS

$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from  Proveedor WHERE (nitproveedor=buscarNitProveedor)) > 0 THEN
            DELETE FROM Proveedor WHERE nitProveedor=buscarNitProveedor;
            return 'proveedoreliminado';
            COMMIT;
        ELSE
            return 'proveedornoexiste';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;       
       
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_registrarUsuario(correoRegistrar varchar(50),datosUsuario varchar (100),passUsuario varchar(255)) RETURNS varchar AS 
$$
    DECLARE
    estadoCuenta CHAR := 'A';
    numeroRol int := 1;
    fechaActual date :=NOW()::date;
    BEGIN
        IF (SELECT count(*) from  Usuarios WHERE (correo=correoRegistrar) ) > 0 THEN
            raise exception 'enuso';            
        ELSE        
            INSERT INTO Usuarios (correo,estado,fechaRegistro,nombreApellidos,contrasena,codRol) VALUES (correoRegistrar,estadoCuenta,fechaActual,datosUsuario,passUsuario,numeroRol);
            return 'registrado';
            COMMIT;
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_buscarRegistroProducto(buscarCodigoProducto varchar(30)) RETURNS varchar 
AS $$
    
    DECLARE
    BEGIN
    IF (SELECT count(*) from productos WHERE (codigoproducto=buscarCodigoProducto)) > 0 THEN
       return   'productoencontrado';  
    ELSE
       return 'productonoencontrado';
    END IF;     
          
    END;
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION PA_insertarFacturaCompra(buscarDocumentoProveedor varchar(50),facturaProveedorFecha date,proveedorNit varchar(20)) RETURNS varchar AS 
$$
    DECLARE
    
        fechaActualHoy date := (SELECT current_date);
    
    BEGIN
        IF (SELECT count(*) from FacturaCompra WHERE documentoProveedor=buscarDocumentoProveedor) > 0 THEN
            return 'enuso';
        ELSE
            
            INSERT INTO FacturaCompra(documentoProveedor,fechaRegistro,fechaFacturaProveedor,nitProveedor,estado) VALUES (buscarDocumentoProveedor,fechaActualHoy,facturaProveedorFecha,proveedorNit,'N');
            return 'registrado';
            COMMIT;
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_aumentarInventario() RETURNS TRIGGER AS 
$$
    DECLARE
    
    BEGIN
            IF (SELECT count(*) from Inventario WHERE codigoProducto=NEW.codigoProducto) > 0 THEN             
               
                UPDATE Inventario SET cantidadComprado = cantidadComprado+NEW.cantidadComprado,
                precioCompra = ((precioCompra*cantidadComprado) + (NEW.precioCompra*NEW.cantidadComprado))/(cantidadComprado + NEW.cantidadComprado)
            
                
                WHERE codigoProducto=NEW.codigoProducto;
                return NEW;                
                COMMIT;   
            ELSE

                INSERT INTO Inventario(codigoProducto,cantidadComprado,precioCompra)
                VALUES(NEW.codigoProducto,NEW.cantidadComprado,NEW.precioCompra);
                
                return new;
                COMMIT;
                
            END IF;

    EXCEPTION
    WHEN OTHERS THEN
        
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

drop trigger TR_actStock ON detallefacturacompra;
drop function PA_aumentarInventario ;


CREATE TRIGGER TR_actStock AFTER UPDATE ON detallefacturacompra
FOR EACH ROW
EXECUTE PROCEDURE PA_aumentarInventario();

CREATE OR REPLACE FUNCTION PA_disminuirInventario() RETURNS TRIGGER AS 
$$
    DECLARE
    
    BEGIN
            IF (SELECT count(*) from Inventario WHERE codigoProducto=NEW.codigoProducto) > 0 THEN             
               
                UPDATE Inventario SET cantidadComprado = cantidadComprado-NEW.cantidadComprado
                WHERE codigoProducto=NEW.codigoProducto;
                return NEW;                
                COMMIT;                

                
            END IF;

    EXCEPTION
    WHEN OTHERS THEN
        
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';


CREATE TRIGGER TR_disminuirStock AFTER INSERT ON detallefacturaventa
FOR EACH ROW
EXECUTE PROCEDURE PA_disminuirInventario();


CREATE OR REPLACE FUNCTION PA_insertarDetalleFacturaCompra(buscarDocumentoProveedor varchar(50),valorPrecioCompra decimal(10,2),numeroArticulosComprado int,productoCodigo varchar(50)) RETURNS varchar AS 
$$
    DECLARE
    
    BEGIN
        IF (SELECT count(*) from FacturaCompra WHERE documentoProveedor=buscarDocumentoProveedor) > 0 THEN
            IF (SELECT count(*) from Productos WHERE codigoProducto=productoCodigo) > 0 THEN
                INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor,estado) VALUES (valorPrecioCompra,numeroArticulosComprado,productoCodigo,buscarDocumentoProveedor,'N');
                return 'registrado';
                COMMIT;
            ELSE
                return 'productonoencontrado';
            END IF;
        ELSE
            return 'facturacompranoencontrado';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION PA_cerrarFacturaCompra(buscarNumeroFacturaCompra varchar(50)) RETURNS varchar AS 
$$
    DECLARE
    BEGIN
        IF (SELECT count(*) from detallefacturacompra WHERE documentoproveedor=buscarNumeroFacturaCompra) > 0 THEN
            UPDATE detallefacturacompra set estado='P' where documentoproveedor=buscarNumeroFacturaCompra;
            UPDATE facturacompra set estado='P' where documentoproveedor=buscarNumeroFacturaCompra;
            return 'actualizado';
            COMMIT;
        ELSE
            return 'facturainvalida';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION anular_factura_compra(IN d_documentoProveedor_anular VARCHAR)
RETURNS VARCHAR AS $$
DECLARE
    v_anulada CHAR = 'A';
    v_producto_id varchar;
    v_cantidad INTEGER;
    detalles record;
BEGIN
    -- Verificar que la factura existe
    IF (SELECT count(*) FROM facturacompra WHERE documentoproveedor = d_documentoProveedor_anular) > 0 THEN


        -- Verificar que la factura no ha sido anulada

        IF (SELECT count(*) FROM facturacompra WHERE documentoproveedor = d_documentoProveedor_anular AND estado='P') > 0 THEN
            
            -- Anular la factura
            UPDATE facturacompra SET estado = 'A' WHERE documentoproveedor = d_documentoProveedor_anular;

            
              -- Restar las cantidades de productos comprados desde la tabla de inventario
    FOR detalles IN (SELECT codigoproducto, cantidadcomprado FROM detallefacturacompra WHERE documentoproveedor = d_documentoProveedor_anular)
    LOOP
        v_producto_id = detalles.codigoproducto;
        v_cantidad = detalles.cantidadcomprado;

    UPDATE inventario SET cantidadcomprado = cantidadcomprado - v_cantidad WHERE codigoproducto = v_producto_id;
         -- UPDATE inventario SET cantidadcomprado = 2 WHERE codigoproducto = 'cria';

  END LOOP;
            
            return 'anulado';
            
        ELSE

            RETURN 'noanulado';
        END IF;



    ELSE
        return 'facturanoexiste';
    END IF;




EXCEPTION
    WHEN OTHERS THEN
        RETURN 'errorsucedido';
END;
$$ LANGUAGE plpgsql;




CREATE OR REPLACE FUNCTION anular_factura_venta(IN d_documentoFacturaVenta_anular INTEGER)
RETURNS VARCHAR AS $$
DECLARE
    v_anulada CHAR = 'A';
    v_producto_id varchar;
    v_cantidad_factura_venta integer;
    detalles_factura_venta record;
BEGIN
    -- Verificar que la factura existe
    IF (SELECT count(*) FROM facturaventa WHERE numerodocumentofacturaventa = d_documentoFacturaVenta_anular) > 0 THEN
    
        -- Verificar que la factura no ha sido anulada
        IF (SELECT count(*) FROM facturaventa WHERE numerodocumentofacturaventa = d_documentoFacturaVenta_anular AND estado='P') > 0 THEN
          
            -- Anular la factura
            UPDATE facturaventa SET estado = 'A' WHERE numerodocumentofacturaventa = d_documentoFacturaVenta_anular;
            
  
              -- Restar las cantidades de productos comprados desde la tabla de inventario
    FOR detalles_factura_venta IN (SELECT codigoproducto, cantidadcomprado FROM detallefacturaventa WHERE numerodocumentofacturaventa = d_documentoFacturaVenta_anular)
    LOOP
        v_producto_id = detalles_factura_venta.codigoproducto;
        v_cantidad_factura_venta = detalles_factura_venta.cantidadcomprado;

    UPDATE inventario SET cantidadcomprado = cantidadcomprado + v_cantidad_factura_venta WHERE codigoproducto = v_producto_id;

  END LOOP;
            
            return 'anulado';            
        ELSE
            RETURN 'noanulado';
        END IF;

    ELSE
        return 'facturanoexiste';
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        RETURN 'errorsucedido';
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION PA_eliminarCliente(IN buscarCodigoCliente integer) RETURNS varchar AS

$$
    DECLARE

    BEGIN
        IF (SELECT count(*) from  Clientes WHERE (codigocliente=buscarCodigoCliente)) > 0 THEN
            DELETE FROM clientes WHERE codigocliente=buscarCodigoCliente;
            return 'clienteeliminado';
            COMMIT;
        ELSE
            return 'clientenoexiste';
        END IF;
    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;       
       
    END;
$$ LANGUAGE 'plpgsql';
