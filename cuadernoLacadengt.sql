CREATE DATABASE perseverance;

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

CREATE TABLE Productos(
    codigoProducto varchar(50) NOT NULL,
    nombre varchar(100) NOT NULL,
    foto varchar(100) NOT NULL,
    PRIMARY KEY (codigoProducto)
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
drop 

/*drop table DetalleFacturaCompra;*/

CREATE TABLE DetalleFacturaCompra(
    idDetalle SERIAL NOT NULL,
    precioCompra REAL NOT NULL,
    cantidadComprado int NOT NULL,
    codigoProducto varchar(50) NOT NULL,
    documentoProveedor VARCHAR(50) NOT NULL,
    PRIMARY KEY (idDetalle),
    CONSTRAINT PK_DetalleFacturaCompra FOREIGN KEY (documentoProveedor) REFERENCES FacturaCompra(documentoProveedor),  
    CONSTRAINT PK_Producto_Detalle FOREIGN KEY (codigoProducto) REFERENCES Productos(codigoProducto)  
);



