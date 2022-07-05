CREATE DATABASE perseverance;

CREATE TABLE Rol(
    codRol serial NOT NULL,
    nombreRol varchar(20) NOT NULL,
    PRIMARY KEY (codRol)
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

 INSERT INTO Empresas VALUES('812752-2',"Edgar Lopez","Colonia carrabanchel","hola.png","santoslopez@google.com");

INSERT INTO Rol(codRol,nombreRol) VALUES(1,'admin');
INSERT INTO Rol(codRol,nombreRol) VALUES(2,'cajero');

CREATE TABLE Usuarios(
    correo varchar(50) NOT NULL,
    estado CHAR(1) CHECK(estado='A' OR estado='I') NOT NULL,
    fechaRegistro timestamp NOT NULL,
    nombreApellidos varchar (100) NOT NULL,
    contrasena varchar(255) NOT NULL,
    PRIMARY KEY (correo)
);

CREATE TABLE Proveedor(
    nitProveedor varchar(20) NOT NULL,
    nombreEmpresa varchar(60) NOT NULL,
    logo varchar(100),
    direccion varchar(100) NOT NULL,
    telefono varchar(15) NOT NULL,
    PRIMARY KEY (nitProveedor)
);

INSERT INTO Proveedor values('812752-2',"Ferreteria La Cadena","","1era calle A 4-47 zona 11","24403002");

CREATE TABLE Clientes(
    codigoCliente SERIAL NOT NULL,
    nombreApellidos varchar(100) NOT NULL,
    direccion varchar(50) NOT NULL,
    nitCliente varchar(20) NOT NULL DEFAULT 'c/f',
    telefono varchar(15)
    PRIMARY KEY (codigoCliente)
);

INSERT INTO Clientes values(1,'santos lopez', 'guatemala ciudad','812724-S',24003020);


CREATE TABLE Productos(
    codigoProducto varchar(50) NOT NULL,
    nombre varchar(100) NOT NULL,
    foto varchar(100) NOT NULL,
    PRIMARY KEY (codigoProducto)
);