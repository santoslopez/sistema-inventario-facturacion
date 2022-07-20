
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
    fechaRegistro timestamp NOT NULL,
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
    nitCliente varchar(20) NOT NULL DEFAULT 'c/f',
    telefono varchar(15),
    PRIMARY KEY (codigoCliente)
);

CREATE TABLE FacturaCompra(
    numeroDocumento SERIAL NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    fechaRegistro timestamp NOT NULL,
    fechaFacturaProveedor  timestamp NOT NULL,
    nitProveedor varchar(20) NOT NULL,
    PRIMARY KEY (documentoProveedor),
    CONSTRAINT PK_FacturaCompra_NitProveedor FOREIGN KEY (nitProveedor) REFERENCES Proveedor(nitProveedor )  
);


/*drop table DetalleFacturaCompra;*/

CREATE TABLE DetalleFacturaCompra(
    idDetalle SERIAL NOT NULL,
    precioCompra decimal(10,2) NOT NULL CHECK(precioCompra > 0),
    cantidadComprado int NOT NULL CHECK(cantidadComprado > 0),
    codigoProducto varchar(50) NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    PRIMARY KEY (idDetalle),
    CONSTRAINT PK_DetalleFacturaCompra FOREIGN KEY (documentoProveedor) REFERENCES FacturaCompra(documentoProveedor),  
    CONSTRAINT PK_Producto_Detalle FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)  
);


CREATE TABLE Inventario(
    codInventario SERIAL NOT NULL,
    codigoProducto varchar(50) NOT NULL,
    cantidadComprado int NOT NULL CHECK(cantidadComprado >= 0),
    costoActual decimal(10,2) NOT NULL CHECK(costoActual >= 0),
    PRIMARY KEY (codInventario),
    CONSTRAINT PK_DetalleProductoCompra FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)  
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
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION PA_registrarProveedor(proveedorNit varchar(20), empresaNombre varchar(60), logoEmpresa varchar(100), direccionEmpresa varchar(100), telefonoEmpresa varchar(15)) RETURNS BOOLEAN AS 
$$
    DECLARE

    BEGIN
        INSERT INTO Proveedor VALUES (proveedorNit,empresaNombre,logoEmpresa,direccionEmpresa,telefonoEmpresa);
        RETURN TRUE;
        COMMIT;

        Exception 
            When others then return FALSE;
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
        ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';




CREATE OR REPLACE FUNCTION PA_actualizarDetalleFacturaCompra(precioC decimal(10,2),  cantidadC int, codigoP varchar(50),documentoP VARCHAR(50),idD ) RETURNS BOOLEAN AS 
$$
    DECLARE
  
    BEGIN
        UPDATE DetalleFacturaCompra SET precioCompra=precioC,cantidadComprado=cantidadC,codigoProducto=codigoP WHERE documentoProveedor=documentoP AND idDetalle=idD;
        RETURN TRUE;
        COMMIT;
        
        Exception 
            When others then return FALSE;
            ROLLBACK;
    END;
$$ LANGUAGE 'plpgsql';





SELECT I.codigoProducto AS COD,descripcion AS Producto,I.cantidadComprado AS UnidadesDisponibles,I.costoActual
FROM Inventario AS I
     INNER JOIN DetalleFacturaCompra
ON I.codigoProducto = DetalleFacturaCompra.codigoProducto
     INNER JOIN Productos
ON DetalleFacturaCompra.codigoProducto = Productos.codigoProducto;



CREATE OR REPLACE FUNCTION TR_ActualizarInventarioInsertar() RETURNS TRIGGER AS 
$$
DECLARE 

BEGIN;
    UPDATE Inventario SET cantidadComprado = cantidadComprado + OLD.cantidadComprado
    WHERE codigoProducto=NEW.codigoProducto;
    COMMIT;
    return NEW;
    
END;
$$ LANGUAGE 'plpgsql';

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

CREATE OR REPLACE FUNCTION TR_ActualizarInventarioInsertarDel() RETURNS TRIGGER AS 
$$
DECLARE 

BEGIN

    UPDATE Inventario SET cantidadComprado =  cantidadComprado - OLD.cantidadComprado
        WHERE codigoProducto=OLD.codigoProducto;
        return OLD;
        
END;
$$ LANGUAGE 'plpgsql';


CREATE TRIGGER TR_ActualizarInventarioInsertarDel
AFTER DELETE ON DetalleFacturaCompra

FOR EACH ROW EXECUTE PROCEDURE TR_ActualizarInventarioInsertarDel();







DROP TRIGGER TR_ActualizarInventarioAdd on DetalleFacturaCompra;







DROP TRIGGER TR_ActualizarInventarioInsertar on DetalleFacturaCompra;