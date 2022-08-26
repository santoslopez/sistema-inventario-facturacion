
CREATE TABLE Rol(
    codRol serial NOT NULL,
    nombreRol varchar(20) NOT NULL,
    PRIMARY KEY (codRol)
);

INSERT INTO Rol(codRol,nombreRol) VALUES(1,'admin');
INSERT INTO Rol(codRol,nombreRol) VALUES(2,'cajero');

CREATE TABLE Usuarios(
    correo varchar(50) NOT NULL,
    estado CHAR(1) CHECK(estado='A' OR estado='I') NOT NULL,
    fechaRegistro date NOT NULL,
    nombreApellidos varchar (100) NOT NULL,
    contrasena varchar(255) NOT NULL,
    codRol int NOT NULL,
    PRIMARY KEY (correo),
    CONSTRAINT PK_ROL_USUARIOS FOREIGN KEY (codRol) REFERENCES Rol(codRol)  
);

INSERT INTO Usuarios(correo,estado,fechaRegistro,nombreApellidos,contrasena,codRol) VALUES('lopeztsantos@gmail.com','A','2022-07-19','Santos Lopez','$2y$12$7Ikmzv/CMLj7UMYPNucTZOBQEkrNSWcihinohAwXTCe83qdgR1XOO',1);

CREATE TABLE Productos(
    codigoProducto varchar(30) NOT NULL,
    descripcion varchar(150) NOT NULL,
    foto varchar(100) NOT NULL DEFAULT 'profile.png',
    PRIMARY KEY (codigoProducto)
);

CREATE TABLE Empresas(
    nitEmpresa varchar(20) NOT NULL,
    nombre varchar(100) NOT NULL,
    direccion varchar(100) NOT NULL,
    logoEmpresa varchar(100) NOT NULL DEFAULT 'profile.png',
    correo varchar(50) NOT NULL,
    PRIMARY KEY (nitEmpresa),
    CONSTRAINT PK_USUARIOS_EMPRESAS FOREIGN KEY (correo) REFERENCES Usuarios(correo)  
 );

CREATE TABLE Proveedor(
    nitProveedor varchar(20) NOT NULL,
    nombreEmpresa varchar(60) NOT NULL,
    logo varchar(100),
    direccion varchar(100) NOT NULL,
    telefono varchar(15) NOT NULL,
    PRIMARY KEY (nitProveedor)
);

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
    PRIMARY KEY (documentoProveedor),
    CONSTRAINT PK_FacturaCompra_NitProveedor FOREIGN KEY (nitProveedor) REFERENCES Proveedor(nitProveedor )  
);


CREATE TABLE DetalleFacturaCompra(
    idDetalle SERIAL NOT NULL,
    precioCompra decimal(10,2) NOT NULL CHECK(precioCompra >= 0),
    cantidadComprado int NOT NULL CHECK(cantidadComprado > 0),
    codigoProducto varchar(50) NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    PRIMARY KEY (idDetalle),
    CONSTRAINT PK_DetalleFacturaCompra FOREIGN KEY (documentoProveedor) REFERENCES FacturaCompra(documentoProveedor),  
    CONSTRAINT PK_Producto_Detalle FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)  
);

CREATE TABLE FacturaVenta(
    numeroDocumentoFacturaVenta SERIAL NOT NULL,
    codigoCliente int NOT NULL,
    totalVenta float NOT NULL,
    fechaFacturaVenta date NOT NULL,
    PRIMARY KEY (numeroDocumentoFacturaVenta),
    CONSTRAINT PK_FacturaVentaCliente FOREIGN KEY (codigoCliente) REFERENCES Clientes(codigoCliente)
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
    costoActual decimal(10,2) NOT NULL CHECK(costoActual >= 0),
    PRIMARY KEY (codInventario),
    CONSTRAINT PK_DetalleProductoCompra FOREIGN KEY (codigoProducto) 
    REFERENCES Productos(codigoProducto)  
);


CREATE OR REPLACE FUNCTION TG_ActualizarStockVender() RETURNS TRIGGER AS 
$$
DECLARE 

BEGIN
    UPDATE Inventario SET cantidadComprado = cantidadComprado - NEW.cantidadComprado
    WHERE codigoProducto=NEW.codigoProducto;
    return NEW;
END;
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER TG_ActualizarStockVender
AFTER INSERT ON DetalleFacturaVenta
FOR EACH ROW EXECUTE PROCEDURE TG_ActualizarStockVender();



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
        IF (SELECT count(*) from Clientes WHERE (nitCliente=nitC) AND (nitCliente!='c/f')) > 0 THEN
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

CREATE OR REPLACE FUNCTION PA_controlInventario(precioCompraD decimal(10,2),cantidadComp int,productoCod  varchar(50), docPro VARCHAR(50)) RETURNS varchar AS 
$$
    DECLARE
    
    
    BEGIN

        IF (SELECT count(*) from Productos WHERE codigoProducto=productoCod) > 0 THEN

            IF (SELECT count(*) from Inventario WHERE codigoProducto=productoCod) > 0 THEN
    
                INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor)
                VALUES (precioCompraD,cantidadComp,productoCod,docPro);
                
                UPDATE Inventario SET cantidadComprado = cantidadComp + cantidadComprado,
                costoactual = ((costoactual*cantidadComprado) + (precioCompraD*cantidadComp))/(cantidadComp + cantidadComprado)
                WHERE codigoProducto=productoCod;
            
                return 'actualizadoStock'; 
                COMMIT;
                
            ELSE
                INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor)
                VALUES (precioCompraD,cantidadComp,productoCod,docPro);
                
                INSERT INTO Inventario(codigoProducto,cantidadComprado,costoActual) VALUES
                (productoCod,cantidadComp,precioCompraD);
                
                return 'agregadoStock';
                COMMIT;
                
            END IF;
        ELSE
            return 'productonoexiste';
         END IF;

    EXCEPTION
    WHEN OTHERS THEN
        return 'errorsucedido';
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';

/*lo anterior ya se verifico actualiza el stock correctamente al agregar compras,
realiza promedio de costo de producto al comprar si hay productos existentes,
al vender resta el stock.

*/





CREATE OR REPLACE FUNCTION TR_eliminarDetalleComprobanteVenta() RETURNS TRIGGER AS

$$
DECLARE
BEGIN
 UPDATE Inventario SET cantidadComprado = cantidadComprado + OLD.cantidadComprado
              
                WHERE codigoProducto=OLD.codigoProducto;
 
 RETURN OLD;

END;
$$ LANGUAGE 'plpgsql';


CREATE TRIGGER TR_eliminarDetalleComprobanteVenta
AFTER DELETE ON DetalleFacturaVenta
FOR EACH ROW EXECUTE PROCEDURE TR_eliminarDetalleComprobanteVenta();
/*pendiente anterior
*/





SELECT I.codigoProducto AS COD,descripcion AS Producto,I.cantidadComprado AS UnidadesDisponibles,I.costoActual
FROM Inventario AS I
     INNER JOIN DetalleFacturaCompra
ON I.codigoProducto = DetalleFacturaCompra.codigoProducto
     INNER JOIN Productos
ON DetalleFacturaCompra.codigoProducto = Productos.codigoProducto;


CREATE TRIGGER TR_ActualizarInventarioInsertar
AFTER INSERT ON DetalleFacturaCompra

FOR EACH ROW EXECUTE PROCEDURE TR_ActualizarInventarioInsertar();


CREATE OR REPLACE FUNCTION TR_ActualizarInventarioInsertar1() RETURNS TRIGGER AS 
$$
DECLARE 

BEGIN;

IF NEW.cantidadComprado > OLD.cantidadComprado THEN 

    UPDATE Inventario SET cantidadComprado = cantidadComprado - (NEW.cantidadComprado - OLD.cantidadComprado)
        WHERE codigoProducto=NEW.codigoProducto;
        COMMIT;
        return NEW;
        

ELSE
    UPDATE Inventario SET cantidadComprado = cantidadComprado + (OLD.cantidadComprado - NEW.cantidadComprado)
        WHERE codigoProducto=NEW.codigoProducto;
        COMMIT;
        return NEW;
        
END IF;

END;
$$ LANGUAGE 'plpgsql';


CREATE TRIGGER TR_ActualizarInventarioInsertar1
AFTER UPDATE ON DetalleFacturaCompra

FOR EACH ROW EXECUTE PROCEDURE TR_ActualizarInventarioInsertar1();




DROP TRIGGER TR_ActualizarInventarioAdd on DetalleFacturaCompra;
DROP TRIGGER TR_ActualizarInventarioInsertar on DetalleFacturaCompra;

DROP FUNCTION PA_insertarCliente;

CREATE OR REPLACE FUNCTION PA_consultarInventario(buscarProducto varchar(30)) RETURNS 

AS 
$$
    DECLARE
    stockActual int := 0;
    BEGIN
        IF (SELECT count(*) from  Inventario WHERE (codigoProducto=buscarProducto) ) > 0 THEN
            
            return query select I.codigoproducto,descripcion,I.cantidadComprado,I.costoActual from productos
            INNER JOIN Inventario AS I ON I.codigoProducto=Productos.codigoProducto AND Productos.codigoProducto=buscarProducto;
            
            
        END IF;
       
    END;
$$ LANGUAGE 'plpgsql';

SELECT * FROM INVENTARIO;
select I.codigoproducto,descripcion,I.cantidadComprado,I.costoActual from productos
            INNER JOIN Inventario AS I ON I.codigoProducto=Productos.codigoProducto AND Productos.codigoProducto='19000';
            
       
       
       CREATE OR REPLACE FUNCTION PA_consultarInventario(buscarProducto varchar(30)) RETURNS integer
AS $$
    DECLARE
     stockActual integer;
    BEGIN
            stockActual = (SELECT cantidadcomprado from  Inventario WHERE (codigoProducto=buscarProducto));
        IF ( stockActual) > 0 THEN
            
        
            RETURN stockActual;
        
        ELSE
            RETURN -1;
        
        END IF;
       
    END;
$$ LANGUAGE 'plpgsql';

SELECT DISTINCT facturaventa.numerodocumentofacturaventa,facturaventa.totalventa,nitcliente AS nitcliente  FROM Clientes INNER JOIN FacturaVenta AS facturaventa
ON Clientes.codigocliente=FacturaVenta.codigocliente INNER JOIN  detallefacturaventa
ON FacturaVenta.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa

WHERE facturaventa.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa;