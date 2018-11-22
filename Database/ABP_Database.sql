DROP DATABASE IF EXISTS ABP;

CREATE DATABASE IF NOT EXISTS ABP;

USE ABP;

CREATE TABLE IF NOT EXISTS ROL(
  ID int(225) AUTO_INCREMENT NOT NULL,
  NOMBRE varchar(25) NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS USUARIO(
  LOGIN varchar(25) NOT NULL,
  PASSWORD varchar(50) NOT NULL,
  NOMBRE varchar(25) NOT NULL,
  APELLIDOS  varchar(50) NOT NULL,
  GENERO varchar(10) NOT NULL,
  ROL_ID int(225) NOT NULL,
  PRIMARY KEY(LOGIN),
  FOREIGN KEY (ROL_ID) REFERENCES ROL (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS PAREJA(
  ID int(225) AUTO_INCREMENT NOT NULL,
  JUGADOR_1 varchar(25) NOT NULL,
  JUGADOR_2 varchar(25) NOT NULL,
  CAPITAN varchar(25) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (JUGADOR_1) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE,
  FOREIGN KEY (JUGADOR_2) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE,
  FOREIGN KEY (CAPITAN) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS PISTA(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  NOMBRE varchar(25) NOT NULL,
  TIPO varchar(25) NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS HORARIO(
  ID int(225) AUTO_INCREMENT NOT NULL,
  HORA_INICIO time NOT NULL,
  HORA_FIN time NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS CAMPEONATO(
  ID int(225) AUTO_INCREMENT NOT NULL,
  NOMBRE varchar(50) NOT NULL,
  FECHA date NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS CATEGORIA(
  ID int(225) AUTO_INCREMENT NOT NULL,
  NIVEL int(5) NOT NULL,
  GENERO varchar(10) NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS CAMPEONATO_CATEGORIA(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  CAMPEONATO_ID int(225) NOT NULL,
  CATEGORIA_ID int(225) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (CAMPEONATO_ID) REFERENCES CAMPEONATO (ID) ON DELETE CASCADE,
  FOREIGN KEY (CATEGORIA_ID) REFERENCES CATEGORIA (ID) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS GRUPO(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  NOMBRE char(1) NOT NULL,
  CAMPEONATO_ID int(225) NOT NULL,
  CATEGORIA_ID int(225) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (CAMPEONATO_ID) REFERENCES CAMPEONATO (ID) ON DELETE CASCADE,
  FOREIGN KEY (CATEGORIA_ID) REFERENCES CATEGORIA (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS INSCRIPCION(
  FECHA date NOT NULL,
  PAREJA_ID int(225) NOT NULL,
  CAM_CAT_ID int(225) NOT NULL,
  GRUPO_ID int(255),
  PRIMARY KEY(PAREJA_ID, CAM_CAT_ID),
  FOREIGN KEY (PAREJA_ID) REFERENCES PAREJA (ID) ON DELETE CASCADE,
  FOREIGN KEY (CAM_CAT_ID) REFERENCES CAMPEONATO_CATEGORIA (ID) ON DELETE CASCADE,
  FOREIGN KEY (GRUPO_ID) REFERENCES GRUPO (ID) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS RESERVA(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  USUARIO_LOGIN varchar(25) NOT NULL,
  PISTA_ID int(225) NOT NULL,
  FECHA date NOT NULL,
  HORARIO_ID int(225) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (USUARIO_LOGIN) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE,
  FOREIGN KEY (PISTA_ID) REFERENCES PISTA (ID) ON DELETE CASCADE,
  FOREIGN KEY (HORARIO_ID) REFERENCES HORARIO (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ENFRENTAMIENTO(
  ID int(225) AUTO_INCREMENT NOT NULL,
  GRUPO_ID int(225) NOT NULL,
  RESULTADO varchar(25),
  PAREJA_1 int(225) NOT NULL,
  PAREJA_2 int(225) NOT NULL,
  RESERVA_ID int(225),
  PRIMARY KEY(ID),
  FOREIGN KEY (PAREJA_1) REFERENCES PAREJA (ID) ON DELETE CASCADE,
  FOREIGN KEY (PAREJA_2) REFERENCES PAREJA (ID) ON DELETE CASCADE,
  FOREIGN KEY (RESERVA_ID) REFERENCES RESERVA (ID) ON DELETE CASCADE,
  FOREIGN KEY (GRUPO_ID) REFERENCES GRUPO (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS HUECO(
  ID int(225) AUTO_INCREMENT NOT NULL,
  FECHA date NOT NULL,
  ENFRENTAMIENTO_ID int(225) NOT NULL,
  PAREJA_ID int (255) NOT NULL,
  HORARIO_ID int(225) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (PAREJA_ID) REFERENCES PAREJA (ID),
  FOREIGN KEY (ENFRENTAMIENTO_ID) REFERENCES ENFRENTAMIENTO (ID) ON DELETE CASCADE,
  FOREIGN KEY (HORARIO_ID) REFERENCES HORARIO (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CLASIFICACION(
  ID int(225) AUTO_INCREMENT NOT NULL,
  PAREJA_ID int(225) NOT NULL,
  GRUPO_ID int(225) NOT NULL,
  PUNTOS int(225) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (PAREJA_ID) REFERENCES PAREJA (ID) ON DELETE CASCADE,
  FOREIGN KEY (GRUPO_ID) REFERENCES GRUPO (ID) ON DELETE CASCADE

);


CREATE TABLE IF NOT EXISTS PARTIDO(
  ID int(225) AUTO_INCREMENT NOT NULL,
  FECHA date NOT NULL,
  RESERVA_ID int(255),
  PISTA_ID int(255),
  HORARIO_ID int(255),
  INSCRIPCIONES INT(1) NULL DEFAULT '0',
  PRIMARY KEY(ID),
  FOREIGN KEY (RESERVA_ID) REFERENCES RESERVA (ID) ON DELETE CASCADE,
  FOREIGN KEY (PISTA_ID) REFERENCES PISTA (ID) ON DELETE CASCADE,
  FOREIGN KEY (HORARIO_ID) REFERENCES HORARIO (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS USUARIO_PARTIDO(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  USUARIO_LOGIN varchar(25) NOT NULL,
  PARTIDO_ID int(255) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (USUARIO_LOGIN) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE,
  FOREIGN KEY (PARTIDO_ID) REFERENCES PARTIDO (ID) ON DELETE CASCADE
);



USE ABP;

-- INSERTS DE TABLA ROL
INSERT INTO ROL (ID, NOMBRE) VALUES (1, "ADMIN"),
                                    (2, "DEPORTISTA");

-- INSERTS DE TABLA USUARIO
INSERT INTO USUARIO (LOGIN, PASSWORD, NOMBRE, APELLIDOS, GENERO, ROL_ID) VALUES ("admin","admin", "Administrador", "Administrador", "Hombre", 1),
                                                                                ("pepe","pepe", "Jose Ramon", "Perez Lopez", "Hombre", 2),
                                                                                ("carlos","carlos", "Carlos", "Dieguez Torres", "Hombre", 2),
                                                                                ("maria","maria", "Maria", "Sanchez Dominguez", "Mujer", 2),
                                                                                ("jose","jose", "Jose", "Garcia Fernandez", "Hombre", 2),
                                                                                ("lucia","lucia", "Lucia", "Rosales Montero", "Mujer", 2),
                                                                                ("sara","sara", "Sara", "Penedo Villanueva", "Mujer", 2),
                                                                                ("lucas","lucas", "Lucas", "Gonzalez Baltar", "Hombre", 2),
                                                                                ("agustin","agustin", "Agustin", "Calderon Pelaez", "Hombre", 2),
                                                                                ("carmen","carmen", "Carmen", "Plaza Paz", "Mujer", 2),
                                                                                ("felix","felix", "Felix", "Alegria Perez", "Hombre", 2),
                                                                                ("alfonso","alfonso", "Alfonso", "Castillejo Ruanova", "Hombre", 2),
                                                                                ("alicia","alicia", "Alicia", "Quintana Jimenez", "Mujer", 2),
                                                                                ("jaime","jaime", "Jaime", "Rios Roca", "Hombre", 2),
                                                                                ("rocio","rocio", "Rocio", "Barroso Santos", "Mujer", 2),
                                                                                ("miguel","miguel", "Miguel", "Contreras Villanueva", "Hombre", 2),
                                                                                ("lorenzo","lorenzo", "Lorenzo", "Puebla Novoa", "Hombre", 2),
                                                                                ("gillermo","gillermo", "Gillermo", "Valderrama Corral", "Hombre", 2),
                                                                                ("paula","paula", "Paula", "Pimentel Lopez", "Mujer", 2),
                                                                                ("alejandra","alejandra", "Alejandra", "Arias Linares", "Mujer", 2),
                                                                                ("marcos","marcos", "Marcos", "Garrido Pozuelo", "Hombre", 2),
                                                                                ("juan","juan", "Juan", "Perez Gonzalez", "Hombre", 2),
                                                                                ("trinidad","trinidad", "Trinidad", "Novas Diaz", "Mujer", 2),
                                                                                ("hector","hector", "Hector", "Arteaga Pombo", "Hombre", 2),
                                                                                ("roberto","roberto", "Roberto", "Ballesteros Fernandez", "Hombre", 2),
                                                                                ("antonia","antonia", "Antonia", "Lorenzo Monserrat", "Mujer", 2),
                                                                                ("sebastian","sebastian", "Sebastian", "Pombo Perez", "Hombre", 2),
                                                                                ("nuria","nuria", "Nuria", "Quinteiro Contreras", "Mujer", 2),
                                                                                ("francisco","francisco", "Francisco", "Torres Rios", "Hombre", 2),
                                                                                ("joel","joel", "Joel", "Rodriguez Nieto", "Hombre", 2),
                                                                                ("yeray","yeray", "Yeray", "Sala Flores", "Hombre", 2),
                                                                                ("adrian","adrian", "Adrian", "Ramos Nunez", "Hombre", 2),
                                                                                ("santiago","santiago", "Santiago", "Gomez Vidal", "Hombre", 2),
                                                                                ("lucas2","lucas2", "Lucas", "Mendez Martin", "Hombre", 2),
                                                                                ("ian","ian", "Ian", "Campos Garrido", "Hombre", 2),
                                                                                ("arturo","arturo", "Arturo", "Rovira Pena", "Hombre", 2),
                                                                                ("rafael","rafael", "Rafael", "Hidalgo Benitez", "Hombre", 2),
                                                                                ("mario","mario", "Mario", "Santos Castillo", "Hombre", 2),
                                                                                ("nico","nico", "Nicolas", "Puig Rodriguez", "Hombre", 2),
                                                                                ("jesus","jesus", "Jesus", "Sanchez Benitez", "Hombre", 2),
                                                                                ("miguelan","miguelan", "Miguel Angel", "Castro Santana", "Hombre", 2),
                                                                                ("julian","julian", "Julian", "Benitez Cruzado", "Hombre", 2),
                                                                                ("sergio","sergio", "Sergio", "Grande Oltra", "Hombre", 2),
                                                                                ("angel","angel", "Angel", "Barbera Revilla", "Hombre", 2),
                                                                                ("nicolas","nicolas", "Nicolas", "Rico Santana", "Hombre", 2),
                                                                                ("marc","marc", "Marc", "Puerto Perez", "Hombre", 2),
                                                                                ("laura","laura", "Laura", "Gomez torres", "Mujer", 2),
                                                                                ("camila","camila", "Camila", "Arias Linares", "Mujer", 2),
                                                                                ("camilo","camilo", "Camilo", "Lorenzo Flores", "Hombre", 2),
                                                                                ("iria","iria", "Domingo", "Diaz Puerto", "Mujer", 2),
                                                                                ("estela","estela", "Estela", "Novoa Garcia", "Mujer", 2);



-- INSERTS DE TABLA PAREJA
INSERT INTO PAREJA (ID, JUGADOR_1, JUGADOR_2, CAPITAN) VALUES (1,"pepe", "carlos", "pepe"),
                                                              (2,"maria", "lucia", "maria"),
                                                              (3,"jose", "lucas", "jose"),
                                                              (4,"sara", "carmen", "sara"),
                                                              (5,"agustin", "felix", "agustin"),
                                                              (6,"alfonso", "jaime", "alfonso"),
                                                              (7,"alicia", "rocio", "alicia"),
                                                              (8,"miguel", "lorenzo", "miguel"),
                                                              (9,"gillermo", "marcos", "gillermo"),
                                                              (10,"paula", "alejandra", "paula"),
                                                              (11,"juan", "hector", "juan"),
                                                              (12,"trinidad", "roberto", "trinidad"),
                                                              (13,"francisco", "nuria", "francisco"),
                                                              (14,"joel", "yeray", "joel"), 
                                                              (15,"adrian", "santiago", "adrian"), 
                                                              (16,"lucas2", "ian", "lucas2"), 
                                                              (17,"arturo", "rafael", "arturo"), 
                                                              (18,"mario", "nico", "mario"), 
                                                              (19,"jesus", "miguelan", "jesus"),
                                                              (20,"julian", "sergio", "julian"),
                                                              (21,"angel", "nicolas", "angel"),
                                                              (22,"marc", "laura", "marc"),
                                                              (23,"camila", "iria", "camila"),
                                                              (24,"estela", "sebastian", "estela"),
                                                              (25,"jesus", "antonia", "jesus") ;
-- INSERTS EN TABLA PISTA
INSERT INTO PISTA (ID, NOMBRE, TIPO) VALUES (1,"Pista 1", "Cubierta"),
                                            (2,"Pista 2", "Cubierta"),
                                            (3,"Pista 3", "Cubierta"),
                                            (4,"Pista 4", "Descubierta"),
                                            (5,"Pista 5", "Descubierta");
-- INSERTS EN TABLA HORARIO
INSERT INTO HORARIO (ID, HORA_INICIO, HORA_FIN) VALUES  (1, '9:00', '10:30'),
                                                        (2, '10:30', '12:00'),
                                                        (3, '12:00', '13:30'),
                                                        (4, '13:30', '15:00'),
                                                        (5, '15:00', '16:30'),
                                                        (6, '16:30', '18:00'),
                                                        (7, '18:00', '19:30'),
                                                        (8, '19:30', '20:00');
-- INSERTS EN TABLA CAMPEONATO
INSERT INTO CAMPEONATO (ID, NOMBRE, FECHA) VALUES   (1, "Campeonato Provincial", '2018-11-20'),
                                                    (2, "Campeonato Autonomico", '2018-11-16'),
                                                    (3, "Campeonato Internacional", '2019-01-15');
-- INSERTS EN TABLA CATEGORIA
INSERT INTO CATEGORIA (ID, NIVEL, GENERO) VALUES  (1, 1, "Masculina"),
                                                  (2, 1, "Femenina"),
                                                  (3, 2, "Masculina"),
                                                  (4, 2, "Femenina"),
                                                  (5, 3, "Masculina"),
                                                  (6, 3, "Femenina"),
                                                  (7, 1, "Mixta"),
                                                  (8, 2, "Mixta"),
                                                  (9, 3, "Mixta");


-- INSERTS EN TABLA RESERVA
INSERT INTO RESERVA (ID, USUARIO_LOGIN, PISTA_ID, FECHA, HORARIO_ID) VALUES   (1, 'pepe', 1, '2018-11-26', 1),
                                                                              (2, 'carlos', 2, '2018-11-26', 1),
                                                                              (3, 'carmen', 3, '2018-11-26', 1),
                                                                              (4, 'lucas', 4, '2018-11-26', 1),
                                                                              (5, 'admin', 5, '2018-11-26', 1),
                                                                              (6, 'nuria', 1, '2018-11-28', 2),
                                                                              (7, 'sara', 2, '2018-11-29', 1),
                                                                              (8, 'pepe', 1, '2018-11-27', 3),
                                                                              (9, 'carlos', 2, '2018-11-27', 3),
                                                                              (10, 'carmen', 3, '2018-11-27', 3),
                                                                              (11, 'lucas', 4, '2018-11-27', 3),
                                                                              (12, 'admin', 5, '2018-11-27', 3),
                                                                              (13, 'pepe', 1, '2018-11-23', 6),
                                                                              (14, 'pepe', 2, '2018-11-23', 5),
                                                                              (15, 'pepe', 3, '2018-11-24', 3),
                                                                              (16, 'pepe', 4, '2018-11-25', 2),
                                                                              (17, 'admin', 1, '2018-11-18', 1),
                                                                              (18, 'admin', 1, '2018-11-18', 2),
                                                                              (19, 'admin', 1, '2018-11-18', 3),
                                                                              (20, 'admin', 1, '2018-11-18', 4),
                                                                              (21, 'admin', 1, '2018-11-18', 5),
                                                                              (22, 'admin', 1, '2018-11-18', 6),
                                                                              (23, 'admin', 1, '2018-11-20', 1),
                                                                              (24, 'admin', 1, '2018-11-20', 2),
                                                                              (25, 'admin', 1, '2018-11-20', 3),
                                                                              (26, 'admin', 1, '2018-11-20', 4),
                                                                              (27, 'admin', 1, '2018-11-20', 5),
                                                                              (28, 'admin', 1, '2018-11-20', 6),
                                                                              (29, 'admin', 1, '2018-11-30', 1),
                                                                              (30, 'admin', 1, '2018-11-30', 2),
                                                                              (31, 'admin', 1, '2018-11-30', 3),
                                                                              (32, 'admin', 1, '2018-11-30', 4),
                                                                              (33, 'admin', 1, '2018-11-30', 5),
                                                                              (34, 'admin', 1, '2018-11-30', 6),
                                                                              (0, 'admin', 1, '2018-11-22', 7),
                                                                              (0, 'admin', 2, '2018-11-22', 7),
                                                                              (0, 'admin', 3, '2018-11-22', 7),
                                                                              (0, 'admin', 4, '2018-11-22', 7),
                                                                              (0, 'admin', 5, '2018-11-22', 7),
                                                                              (0, 'admin', 1, '2018-11-23', 7),
                                                                              (0, 'admin', 2, '2018-11-23', 7),
                                                                              (0, 'admin', 3, '2018-11-23', 7),
                                                                              (0, 'admin', 4, '2018-11-23', 7),
                                                                              (0, 'admin', 5, '2018-11-23', 7),
                                                                              (0, 'admin', 1, '2018-11-24', 7),
                                                                              (0, 'admin', 2, '2018-11-24', 7),
                                                                              (0, 'admin', 3, '2018-11-24', 7),
                                                                              (0, 'admin', 4, '2018-11-24', 7),
                                                                              (0, 'admin', 5, '2018-11-24', 7),
                                                                              (0, 'admin', 1, '2018-11-25', 7),
                                                                              (0, 'admin', 2, '2018-11-25', 7),
                                                                              (0, 'admin', 3, '2018-11-25', 7),
                                                                              (0, 'admin', 4, '2018-11-25', 7),
                                                                              (0, 'admin', 5, '2018-11-25', 7),
                                                                              (0, 'admin', 1, '2018-11-26', 7),
                                                                              (0, 'admin', 2, '2018-11-26', 7),
                                                                              (0, 'admin', 3, '2018-11-26', 7),
                                                                              (0, 'admin', 4, '2018-11-26', 7),
                                                                              (0, 'admin', 5, '2018-11-26', 7),
                                                                              (0, 'admin', 1, '2018-11-27', 7),
                                                                              (0, 'admin', 2, '2018-11-27', 7),
                                                                              (0, 'admin', 3, '2018-11-27', 7),
                                                                              (0, 'admin', 4, '2018-11-27', 7),
                                                                              (0, 'admin', 5, '2018-11-27', 7),
                                                                              (0, 'admin', 1, '2018-11-28', 7),
                                                                              (0, 'admin', 2, '2018-11-28', 7),
                                                                              (0, 'admin', 3, '2018-11-28', 7),
                                                                              (0, 'admin', 4, '2018-11-28', 7),
                                                                              (0, 'admin', 5, '2018-11-28', 7),
                                                                              (0, 'admin', 1, '2018-11-29', 7),
                                                                              (0, 'admin', 2, '2018-11-29', 7),
                                                                              (0, 'admin', 3, '2018-11-29', 7),
                                                                              (0, 'admin', 4, '2018-11-29', 7),
                                                                              (0, 'admin', 5, '2018-11-29', 7),
                                                                              (0, 'admin', 1, '2018-11-30', 7),
                                                                              (0, 'admin', 2, '2018-11-30', 7),
                                                                              (0, 'admin', 3, '2018-11-30', 7),
                                                                              (0, 'admin', 4, '2018-11-30', 7),
                                                                              (0, 'admin', 5, '2018-11-30', 7),
                                                                              (0, 'admin', 1, '2018-12-01', 7),
                                                                              (0, 'admin', 2, '2018-12-01', 7),
                                                                              (0, 'admin', 3, '2018-12-01', 7),
                                                                              (0, 'admin', 4, '2018-12-01', 7),
                                                                              (0, 'admin', 5, '2018-12-01', 7),
                                                                              (0, 'admin', 1, '2018-12-02', 7),
                                                                              (0, 'admin', 2, '2018-12-02', 7),
                                                                              (0, 'admin', 3, '2018-12-02', 7),
                                                                              (0, 'admin', 4, '2018-12-02', 7),
                                                                              (0, 'admin', 5, '2018-12-02', 7),
                                                                              (0, 'admin', 1, '2018-12-03', 7),
                                                                              (0, 'admin', 2, '2018-12-03', 7),
                                                                              (0, 'admin', 3, '2018-12-03', 7),
                                                                              (0, 'admin', 4, '2018-12-03', 7),
                                                                              (0, 'admin', 5, '2018-12-03', 7),
                                                                              (0, 'admin', 1, '2018-12-04', 7),
                                                                              (0, 'admin', 2, '2018-12-04', 7),
                                                                              (0, 'admin', 3, '2018-12-04', 7),
                                                                              (0, 'admin', 4, '2018-12-04', 7),
                                                                              (0, 'admin', 5, '2018-12-04', 7);

-- INSERTS EN TABLA HUECO

-- INSERTS EN TABLA CAMPEONATO_CATEGORIA
INSERT INTO CAMPEONATO_CATEGORIA (ID, CAMPEONATO_ID, CATEGORIA_ID) VALUES   (1, 1, 1),
                                                                            (2, 1, 2),
                                                                            (3, 1, 3),
                                                                            (4, 2, 1),
                                                                            (5, 2, 2),
                                                                            (6, 2, 3),
                                                                            (7, 3, 1),
                                                                            (8, 3, 2),
                                                                            (9, 3, 3);

-- INSERTS EN TABLA GRUPO                                                             
INSERT INTO GRUPO (ID, NOMBRE, CAMPEONATO_ID, CATEGORIA_ID) VALUES
                                                                                (1, '1', 2, 1),
                                                                                (2, '2', 2, 1),
                                                                                (3, '1', 2, 2);

-- INSERTS EN TABLA CLASIFICACION
INSERT INTO CLASIFICACION (ID, PAREJA_ID, GRUPO_ID, PUNTOS) VALUES
                                                                              (1, 6, 1, 0),
                                                                              (2, 14, 1, 0),
                                                                              (3, 7, 1, 0),
                                                                              (4, 15, 1, 0),
                                                                              (5, 8, 1, 0),
                                                                              (6, 16, 1, 0),
                                                                              (7, 1, 1, 0),
                                                                              (8, 9, 1, 0),
                                                                              (9, 2, 2, 0),
                                                                              (10, 10, 2, 0),
                                                                              (11, 3, 2, 0),
                                                                              (12, 11, 2, 0),
                                                                              (13, 4, 2, 0),
                                                                              (14, 12, 2, 0),
                                                                              (15, 5, 2, 0),
                                                                              (16, 13, 2, 0),
                                                                              (17, 22, 3, 0),
                                                                              (18, 23, 3, 0),
                                                                              (19, 24, 3, 0),
                                                                              (20, 17, 3, 0),
                                                                              (21, 25, 3, 0),
                                                                              (22, 18, 3, 0),
                                                                              (23, 19, 3, 0),
                                                                              (24, 20, 3, 0),
                                                                              (25, 21, 3, 0);

-- INSERTS EN TABLA INSCRIPCION
INSERT INTO INSCRIPCION (FECHA, PAREJA_ID, CAM_CAT_ID, GRUPO_ID) VALUES
                                                                                    ('2018-11-15', 1, 4, 1),
                                                                                    ('2018-11-15', 2, 4, 2),
                                                                                    ('2018-11-15', 3, 4, 2),
                                                                                    ('2018-11-15', 4, 4, 2),
                                                                                    ('2018-11-15', 5, 4, 2),
                                                                                    ('2018-11-15', 6, 4, 1),
                                                                                    ('2018-11-15', 7, 4, 1),
                                                                                    ('2018-11-15', 8, 4, 1),
                                                                                    ('2018-11-15', 9, 4, 1),
                                                                                    ('2018-11-15', 10, 4, 2),
                                                                                    ('2018-11-15', 11, 4, 2),
                                                                                    ('2018-11-15', 12, 4, 2),
                                                                                    ('2018-11-15', 13, 4, 2),
                                                                                    ('2018-11-15', 14, 4, 1),
                                                                                    ('2018-11-15', 15, 4, 1),
                                                                                    ('2018-11-15', 16, 4, 1),
                                                                                    ('2018-11-15', 17, 5, 3),
                                                                                    ('2018-11-15', 18, 5, 3),
                                                                                    ('2018-11-15', 19, 5, 3),
                                                                                    ('2018-11-15', 20, 5, 3),
                                                                                    ('2018-11-15', 21, 5, 3),
                                                                                    ('2018-11-15', 22, 5, 3),
                                                                                    ('2018-11-15', 23, 5, 3),
                                                                                    ('2018-11-15', 24, 5, 3),
                                                                                    ('2018-11-15', 25, 5, 3);

-- INSERTS EN TABLA ENFRENTAMIENTO
INSERT INTO ENFRENTAMIENTO (ID, GRUPO_ID, RESULTADO, PAREJA_1, PAREJA_2, RESERVA_ID) VALUES
                                                                                                            (1, 1, '6-4/6-3/0-0', 1, 6, 17),
                                                                                                            (2, 1, '6-4/6-3/0-0', 1, 7, 18),
                                                                                                            (3, 1, NULL, 1, 8, 19),
                                                                                                            (4, 1, NULL, 1, 9, 20),
                                                                                                            (5, 1, NULL, 1, 14, 21),
                                                                                                            (6, 1, NULL, 1, 15, 22),
                                                                                                            (7, 1, '6-4/3-6/6-2', 1, 16, 23),
                                                                                                            (8, 1, '6-4/6-4/0-0', 6, 7, 24),
                                                                                                            (9, 1, NULL, 6, 8, 25),
                                                                                                            (10, 1, NULL, 6, 9, NULL),
                                                                                                            (11, 1, NULL, 6, 14, NULL),
                                                                                                            (12, 1, NULL, 6, 15, NULL),
                                                                                                            (13, 1, NULL, 6, 16, NULL),
                                                                                                            (14, 1, NULL, 7, 8, NULL),
                                                                                                            (15, 1, NULL, 7, 9, NULL),
                                                                                                            (16, 1, NULL, 7, 14, NULL),
                                                                                                            (17, 1, NULL, 7, 15, NULL),
                                                                                                            (18, 1, NULL, 7, 16, NULL),
                                                                                                            (19, 1, NULL, 8, 9, NULL),
                                                                                                            (20, 1, NULL, 8, 14, NULL),
                                                                                                            (21, 1, NULL, 8, 15, NULL),
                                                                                                            (22, 1, NULL, 8, 16, NULL),
                                                                                                            (23, 1, NULL, 9, 14, NULL),
                                                                                                            (24, 1, NULL, 9, 15, NULL),
                                                                                                            (25, 1, NULL, 9, 16, NULL),
                                                                                                            (26, 1, NULL, 14, 15, NULL),
                                                                                                            (27, 1, NULL, 14, 16, NULL),
                                                                                                            (28, 1, NULL, 15, 16, NULL),
                                                                                                            (29, 2, '6-4/3-6/6-2', 2, 3, 26),
                                                                                                            (30, 2, '6-4/6-3/0-0', 2, 4, 27),
                                                                                                            (31, 2, NULL, 2, 5, 28),
                                                                                                            (32, 2, NULL, 2, 10, 29),
                                                                                                            (33, 2, NULL, 2, 11, 30),
                                                                                                            (34, 2, '6-4/6-3/0-0', 2, 12, 31),
                                                                                                            (35, 2, NULL, 2, 13, 32),
                                                                                                            (36, 2, '6-4/2-6/6-4', 3, 4, 33),
                                                                                                            (37, 2, NULL, 3, 5, 34),
                                                                                                            (38, 2, NULL, 3, 10, NULL),
                                                                                                            (39, 2, NULL, 3, 11, NULL),
                                                                                                            (40, 2, NULL, 3, 12, NULL),
                                                                                                            (41, 2, NULL, 3, 13, NULL),
                                                                                                            (42, 2, NULL, 4, 5, NULL),
                                                                                                            (43, 2, NULL, 4, 10, NULL),
                                                                                                            (44, 2, NULL, 4, 11, NULL),
                                                                                                            (45, 2, NULL, 4, 12, NULL),
                                                                                                            (46, 2, NULL, 4, 13, NULL),
                                                                                                            (47, 2, NULL, 5, 10, NULL),
                                                                                                            (48, 2, NULL, 5, 11, NULL),
                                                                                                            (49, 2, NULL, 5, 12, NULL),
                                                                                                            (50, 2, NULL, 5, 13, NULL),
                                                                                                            (51, 2, NULL, 10, 11, NULL),
                                                                                                            (52, 2, NULL, 10, 12, NULL),
                                                                                                            (53, 2, NULL, 10, 13, NULL),
                                                                                                            (54, 2, NULL, 11, 12, NULL),
                                                                                                            (55, 2, NULL, 11, 13, NULL),
                                                                                                            (56, 2, NULL, 12, 13, NULL),
                                                                                                            (57, 3, NULL, 17, 18, NULL),
                                                                                                            (58, 3, NULL, 17, 19, NULL),
                                                                                                            (59, 3, NULL, 17, 20, NULL),
                                                                                                            (60, 3, NULL, 17, 21, NULL),
                                                                                                            (61, 3, NULL, 17, 22, NULL),
                                                                                                            (62, 3, NULL, 17, 23, NULL),
                                                                                                            (63, 3, NULL, 17, 24, NULL),
                                                                                                            (64, 3, NULL, 17, 25, NULL),
                                                                                                            (65, 3, NULL, 18, 19, NULL),
                                                                                                            (66, 3, NULL, 18, 20, NULL),
                                                                                                            (67, 3, NULL, 18, 21, NULL),
                                                                                                            (68, 3, NULL, 18, 22, NULL),
                                                                                                            (69, 3, NULL, 18, 23, NULL),
                                                                                                            (70, 3, NULL, 18, 24, NULL),
                                                                                                            (71, 3, NULL, 18, 25, NULL),
                                                                                                            (72, 3, NULL, 19, 20, NULL),
                                                                                                            (73, 3, NULL, 19, 21, NULL),
                                                                                                            (74, 3, NULL, 19, 22, NULL),
                                                                                                            (75, 3, NULL, 19, 23, NULL),
                                                                                                            (76, 3, NULL, 19, 24, NULL),
                                                                                                            (77, 3, NULL, 19, 25, NULL),
                                                                                                            (78, 3, NULL, 20, 21, NULL),
                                                                                                            (79, 3, NULL, 20, 22, NULL),
                                                                                                            (80, 3, NULL, 20, 23, NULL),
                                                                                                            (81, 3, NULL, 20, 24, NULL),
                                                                                                            (82, 3, NULL, 20, 25, NULL),
                                                                                                            (83, 3, NULL, 21, 22, NULL),
                                                                                                            (84, 3, NULL, 21, 23, NULL),
                                                                                                            (85, 3, NULL, 21, 24, NULL),
                                                                                                            (86, 3, NULL, 21, 25, NULL),
                                                                                                            (87, 3, NULL, 22, 23, NULL),
                                                                                                            (88, 3, NULL, 22, 24, NULL),
                                                                                                            (89, 3, NULL, 22, 25, NULL),
                                                                                                            (90, 3, NULL, 23, 24, NULL),
                                                                                                            (91, 3, NULL, 23, 25, NULL),
                                                                                                            (92, 3, NULL, 24, 25, NULL);





-- INSERTS EN TABLA PARTIDO
INSERT INTO PARTIDO (ID, FECHA, RESERVA_ID, PISTA_ID, HORARIO_ID, INSCRIPCIONES) VALUES   (1, '2018-11-22', NULL, 5, 1, 1),
                                                                                          (2, '2018-11-26', 5, 5, 1, 4),
                                                                                          (3, '2018-11-27', NULL, 1, 4, 2),
                                                                                          (4, '2018-11-28', NULL, 1, 2, 1),
                                                                                          (5, '2018-11-29', NULL, 2, 5, 3),
                                                                                          (6, '2018-12-01', NULL, 3, 2, 0);

-- INSERTS EN TABLA USUARIO_PARTIDO
INSERT INTO USUARIO_PARTIDO (ID, USUARIO_LOGIN, PARTIDO_ID) VALUES  (0, 'pepe', 1),
                                                                    (0, 'lorenzo', 2),
                                                                    (0, 'maria', 2),
                                                                    (0, 'carmen', 2),
                                                                    (0, 'miguel', 2),
                                                                    (0, 'sara', 3),
                                                                    (0, 'pepe', 3),
                                                                    (0, 'pepe', 4),
                                                                    (0, 'paula', 5),
                                                                    (0, 'jose', 5),
                                                                    (0, 'gillermo', 5);

