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

CREATE TABLE IF NOT EXISTS ESCUELA(
  ID int(225) AUTO_INCREMENT NOT NULL,
  NOMBRE varchar(50) NOT NULL,
  DIA enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday', 'Sunday'),
  PISTA_ID int(255),
  HORARIO_ID int(255),
  INSCRIPCIONES INT(1) NULL DEFAULT '0',
  PRIMARY KEY(ID),
  FOREIGN KEY (PISTA_ID) REFERENCES PISTA (ID) ON DELETE CASCADE,
  FOREIGN KEY (HORARIO_ID) REFERENCES HORARIO (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ESCUELA_RESERVA(
  ID int(225) AUTO_INCREMENT NOT NULL,
  RESERVA_ID int(255),
  ESCUELA_ID int(255),
  PRIMARY KEY(ID),
  FOREIGN KEY (RESERVA_ID) REFERENCES RESERVA (ID) ON DELETE CASCADE,
  FOREIGN KEY (ESCUELA_ID) REFERENCES ESCUELA (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS USUARIO_ESCUELA(
  ID int(225) AUTO_INCREMENT NOT NULL ,
  USUARIO_LOGIN varchar(25) NOT NULL,
  ESCUELA_ID int(255) NOT NULL,
  PRIMARY KEY(ID),
  FOREIGN KEY (USUARIO_LOGIN) REFERENCES USUARIO (LOGIN) ON DELETE CASCADE,
  FOREIGN KEY (ESCUELA_ID) REFERENCES ESCUELA (ID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS FINALISTA_CAMPEONATO(
  GRUPO_ID int(255) NOT NULL,
  PAREJA_ID int(255) NOT NULL,
  ETAPA varchar(25) NOT NULL,
  PUNTOS int(255) NOT NULL,
  FECHA date NOT NULL,
  PRIMARY KEY (GRUPO_ID,PAREJA_ID),
  FOREIGN KEY (GRUPO_ID) REFERENCES GRUPO (ID) ON DELETE CASCADE,
  FOREIGN KEY (PAREJA_ID) REFERENCES PAREJA (ID) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS NOTICIA(
  ID int(255) AUTO_INCREMENT NOT NULL,
  TITULO tinytext NOT NULL,
  DESCRIPCION text NOT NULL,
  LINK tinytext,
  PRIMARY KEY (ID)
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
                                                                                ("guillermo","guillermo", "Guillermo", "Valderrama Corral", "Hombre", 2),
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
                                                              (9,"guillermo", "marcos", "guillermo"),
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

INSERT INTO CAMPEONATO (ID, NOMBRE, FECHA) VALUES
                            (1, 'Campeonato Provincial', '2018-11-20'),
                            (2, 'Campeonato Autonomico', '2018-11-16'),
                            (3, 'Campeonato Internacional', '2019-01-15'),
                            (4, 'Campeonato Norte', '2019-01-31');

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
INSERT INTO RESERVA (ID, USUARIO_LOGIN, PISTA_ID, FECHA, HORARIO_ID) VALUES  (1, 'pepe', 1, '2018-11-26', 1),
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
                                                                              (15, 'marc', 3, '2018-11-24', 3),
                                                                              (16, 'alfonso', 4, '2018-11-25', 2),
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
                                                                              (35, 'admin', 1, '2018-11-22', 7),
                                                                              (36, 'admin', 2, '2018-11-22', 7),
                                                                              (37, 'admin', 3, '2018-11-22', 7),
                                                                              (38, 'admin', 4, '2018-11-22', 7),
                                                                              (39, 'admin', 5, '2018-11-22', 7),
                                                                              (40, 'admin', 1, '2018-11-23', 7),
                                                                              (41, 'admin', 2, '2018-11-23', 7),
                                                                              (42, 'admin', 3, '2018-11-23', 7),
                                                                              (43, 'admin', 4, '2018-11-23', 7),
                                                                              (44, 'admin', 5, '2018-11-23', 7),
                                                                              (45, 'admin', 1, '2018-11-24', 7),
                                                                              (46, 'admin', 2, '2018-11-24', 7),
                                                                              (47, 'admin', 3, '2018-11-24', 7),
                                                                              (48, 'admin', 4, '2018-11-24', 7),
                                                                              (49, 'admin', 5, '2018-11-24', 7),
                                                                              (50, 'admin', 1, '2018-11-25', 7),
                                                                              (51, 'admin', 2, '2018-11-25', 7),
                                                                              (52, 'admin', 3, '2018-11-25', 7),
                                                                              (53, 'admin', 4, '2018-11-25', 7),
                                                                              (54, 'admin', 5, '2018-11-25', 7),
                                                                              (55, 'admin', 1, '2018-11-26', 7),
                                                                              (56, 'admin', 2, '2018-11-26', 7),
                                                                              (57, 'admin', 3, '2018-11-26', 7),
                                                                              (58, 'admin', 4, '2018-11-26', 7),
                                                                              (59, 'admin', 5, '2018-11-26', 7),
                                                                              (60, 'admin', 1, '2018-11-27', 7),
                                                                              (61, 'admin', 2, '2018-11-27', 7),
                                                                              (62, 'admin', 3, '2018-11-27', 7),
                                                                              (63, 'admin', 4, '2018-11-27', 7),
                                                                              (64, 'admin', 5, '2018-11-27', 7),
                                                                              (65, 'admin', 1, '2018-11-28', 7),
                                                                              (66, 'admin', 2, '2018-11-28', 7),
                                                                              (67, 'admin', 3, '2018-11-28', 7),
                                                                              (68, 'admin', 4, '2018-11-28', 7),
                                                                              (69, 'admin', 5, '2018-11-28', 7),
                                                                              (70, 'admin', 1, '2018-11-29', 7),
                                                                              (71, 'admin', 2, '2018-11-29', 7),
                                                                              (72, 'admin', 3, '2018-11-29', 7),
                                                                              (73, 'admin', 4, '2018-11-29', 7),
                                                                              (74, 'admin', 5, '2018-11-29', 7),
                                                                              (75, 'admin', 1, '2018-11-30', 7),
                                                                              (76, 'admin', 2, '2018-11-30', 7),
                                                                              (77, 'admin', 3, '2018-11-30', 7),
                                                                              (78, 'admin', 4, '2018-11-30', 7),
                                                                              (79, 'admin', 5, '2018-11-30', 7),
                                                                              (80, 'admin', 1, '2018-12-01', 7),
                                                                              (81, 'admin', 2, '2018-12-01', 7),
                                                                              (82, 'admin', 3, '2018-12-01', 7),
                                                                              (83, 'admin', 4, '2018-12-01', 7),
                                                                              (84, 'admin', 5, '2018-12-01', 7),
                                                                              (85, 'admin', 1, '2018-12-02', 7),
                                                                              (86, 'admin', 2, '2018-12-02', 7),
                                                                              (87, 'admin', 3, '2018-12-02', 7),
                                                                              (88, 'admin', 4, '2018-12-02', 7),
                                                                              (89, 'admin', 5, '2018-12-02', 7),
                                                                              (90, 'admin', 1, '2018-12-03', 7),
                                                                              (91, 'admin', 2, '2018-12-03', 7),
                                                                              (92, 'admin', 3, '2018-12-03', 7),
                                                                              (93, 'admin', 4, '2018-12-03', 7),
                                                                              (94, 'admin', 5, '2018-12-03', 7),
                                                                              (95, 'admin', 1, '2018-12-04', 7),
                                                                              (96, 'admin', 2, '2018-12-04', 7),
                                                                              (97, 'admin', 3, '2018-12-04', 7),
                                                                              (98, 'admin', 4, '2018-12-04', 7),
                                                                              (99, 'admin', 5, '2018-12-04', 7),
                                                                              (100, 'admin', 1, '2018-12-26', 7),
                                                                              (101, 'admin', 2, '2018-12-26', 7),
                                                                              (102, 'admin', 3, '2018-12-26', 7),
                                                                              (103, 'admin', 4, '2018-12-26', 7),
                                                                              (104, 'admin', 5, '2018-12-26', 7),
                                                                              (105, 'admin', 1, '2018-12-27', 7),
                                                                              (106, 'admin', 2, '2018-12-27', 7),
                                                                              (107, 'admin', 3, '2018-12-27', 7),
                                                                              (108, 'admin', 4, '2018-12-27', 7),
                                                                              (109, 'admin', 5, '2018-12-27', 7),
                                                                              (110, 'admin', 1, '2018-12-28', 7),
                                                                              (111, 'admin', 2, '2018-12-28', 7),
                                                                              (112, 'admin', 3, '2018-12-28', 7),
                                                                              (113, 'admin', 4, '2018-12-28', 7),
                                                                              (114, 'admin', 5, '2018-12-28', 7),
                                                                              (115, 'admin', 1, '2018-12-29', 7),
                                                                              (116, 'admin', 2, '2018-12-29', 7),
                                                                              (117, 'admin', 3, '2018-12-29', 7),
                                                                              (118, 'admin', 4, '2018-12-29', 7),
                                                                              (119, 'admin', 5, '2018-12-29', 7),
                                                                              (120, 'admin', 1, '2018-12-30', 7),
                                                                              (121, 'admin', 2, '2018-12-30', 7),
                                                                              (122, 'admin', 3, '2018-12-30', 7),
                                                                              (123, 'admin', 4, '2018-12-30', 7),
                                                                              (124, 'admin', 5, '2018-12-30', 7),
                                                                              (125, 'admin', 1, '2018-12-31', 7),
                                                                              (126, 'admin', 2, '2018-12-31', 7),
                                                                              (127, 'admin', 3, '2018-12-31', 7),
                                                                              (128, 'admin', 4, '2018-12-31', 7),
                                                                              (129, 'admin', 5, '2018-12-31', 7),
                                                                              (130, 'admin', 1, '2019-01-01', 7),
                                                                              (131, 'admin', 2, '2019-01-01', 7),
                                                                              (132, 'admin', 3, '2019-01-01', 7),
                                                                              (133, 'admin', 4, '2019-01-01', 7),
                                                                              (150, 'admin', 5, '2019-01-01', 7),
                                                                              (135, 'admin', 1, '2019-01-02', 7),
                                                                              (136, 'admin', 2, '2019-01-02', 7),
                                                                              (137, 'admin', 3, '2019-01-02', 7),
                                                                              (138, 'admin', 4, '2019-01-02', 7),
                                                                              (139, 'admin', 5, '2019-01-02', 7),
                                                                              (140, 'admin', 1, '2019-01-03', 7),
                                                                              (141, 'admin', 2, '2019-01-03', 7),
                                                                              (142, 'admin', 3, '2019-01-03', 7),
                                                                              (143, 'admin', 4, '2019-01-03', 7),
                                                                              (144, 'admin', 5, '2019-01-03', 7),
                                                                              (145, 'admin', 1, '2019-01-04', 7),
                                                                              (146, 'admin', 2, '2019-01-04', 7),
                                                                              (147, 'admin', 3, '2019-01-04', 7),
                                                                              (148, 'admin', 4, '2019-01-04', 7),
                                                                              (149, 'admin', 5, '2019-01-04', 7),
                                                                              (151, 'admin', 5, '2019-01-08', 7),
                                                                              (152, 'admin', 5, '2019-01-15', 7),
                                                                              (153, 'admin', 5, '2019-01-22', 7),
                                                                              (154, 'admin', 5, '2019-01-29', 7),
                                                                              (155, 'admin', 5, '2019-02-05', 7),
                                                                              (156, 'admin', 5, '2019-02-12', 7),
                                                                              (157, 'admin', 5, '2019-02-19', 7),
                                                                              (158, 'admin', 5, '2019-02-26', 7),
                                                                              (159, 'admin', 5, '2019-03-05', 7),
                                                                              (160, 'admin', 5, '2019-03-12', 7),
                                                                              (161, 'admin', 5, '2019-03-19', 7),
                                                                              (162, 'admin', 5, '2019-03-26', 7),
                                                                              (163, 'admin', 5, '2019-04-02', 7),
                                                                              (164, 'admin', 5, '2019-04-09', 7),
                                                                              (165, 'admin', 5, '2019-04-16', 7),
                                                                              (166, 'admin', 5, '2019-04-23', 7),
                                                                              (167, 'admin', 5, '2019-04-30', 7),
                                                                              (168, 'admin', 5, '2019-05-07', 7),
                                                                              (169, 'admin', 5, '2019-05-14', 7),
                                                                              (170, 'admin', 5, '2019-05-21', 7),
                                                                              (171, 'admin', 5, '2019-05-28', 7),
                                                                              (172, 'admin', 5, '2019-06-04', 7),
                                                                              (173, 'admin', 5, '2019-06-11', 7),
                                                                              (174, 'admin', 5, '2019-06-18', 7),
                                                                              (175, 'admin', 5, '2019-06-25', 7),
                                                                              (176, 'admin', 5, '2019-07-02', 7),
                                                                              (177, 'admin', 5, '2019-07-09', 7),
                                                                              (178, 'admin', 5, '2019-07-16', 7),
                                                                              (179, 'admin', 5, '2019-07-23', 7),
                                                                              (180, 'admin', 5, '2019-07-30', 7),
                                                                              (181, 'admin', 5, '2019-08-06', 7),
                                                                              (182, 'admin', 5, '2019-08-13', 7),
                                                                              (183, 'admin', 5, '2019-08-20', 7),
                                                                              (184, 'admin', 5, '2019-08-27', 7),
                                                                              (185, 'admin', 5, '2019-09-03', 7),
                                                                              (186, 'admin', 5, '2019-09-10', 7),
                                                                              (187, 'admin', 5, '2019-09-17', 7),
                                                                              (188, 'admin', 5, '2019-09-24', 7),
                                                                              (189, 'admin', 5, '2019-10-01', 7),
                                                                              (190, 'admin', 5, '2019-10-08', 7),
                                                                              (191, 'admin', 5, '2019-10-15', 7),
                                                                              (192, 'admin', 5, '2019-10-22', 7),
                                                                              (193, 'admin', 5, '2019-10-29', 7),
                                                                              (194, 'admin', 5, '2019-11-05', 7),
                                                                              (195, 'admin', 5, '2019-11-12', 7),
                                                                              (196, 'admin', 5, '2019-11-19', 7),
                                                                              (197, 'admin', 5, '2019-11-26', 7),
                                                                              (198, 'admin', 5, '2019-12-03', 7),
                                                                              (199, 'admin', 5, '2019-12-10', 7),
                                                                              (200, 'admin', 5, '2019-12-17', 7),
                                                                              (201, 'admin', 5, '2019-12-24', 7),
                                                                              (306, 'admin', 1, '2019-01-01', 1),
                                                                              (307, 'admin', 1, '2019-01-08', 1),
                                                                              (308, 'admin', 1, '2019-01-15', 1),
                                                                              (309, 'admin', 1, '2019-01-22', 1),
                                                                              (310, 'admin', 1, '2019-01-29', 1),
                                                                              (311, 'admin', 1, '2019-02-05', 1),
                                                                              (312, 'admin', 1, '2019-02-12', 1),
                                                                              (313, 'admin', 1, '2019-02-19', 1),
                                                                              (314, 'admin', 1, '2019-02-26', 1),
                                                                              (315, 'admin', 1, '2019-03-05', 1),
                                                                              (316, 'admin', 1, '2019-03-12', 1),
                                                                              (317, 'admin', 1, '2019-03-19', 1),
                                                                              (318, 'admin', 1, '2019-03-26', 1),
                                                                              (319, 'admin', 1, '2019-04-02', 1),
                                                                              (320, 'admin', 1, '2019-04-09', 1),
                                                                              (321, 'admin', 1, '2019-04-16', 1),
                                                                              (322, 'admin', 1, '2019-04-23', 1),
                                                                              (323, 'admin', 1, '2019-04-30', 1),
                                                                              (324, 'admin', 1, '2019-05-07', 1),
                                                                              (325, 'admin', 1, '2019-05-14', 1),
                                                                              (326, 'admin', 1, '2019-05-21', 1),
                                                                              (327, 'admin', 1, '2019-05-28', 1),
                                                                              (328, 'admin', 1, '2019-06-04', 1),
                                                                              (329, 'admin', 1, '2019-06-11', 1),
                                                                              (330, 'admin', 1, '2019-06-18', 1),
                                                                              (331, 'admin', 1, '2019-06-25', 1),
                                                                              (332, 'admin', 1, '2019-07-02', 1),
                                                                              (333, 'admin', 1, '2019-07-09', 1),
                                                                              (334, 'admin', 1, '2019-07-16', 1),
                                                                              (335, 'admin', 1, '2019-07-23', 1),
                                                                              (336, 'admin', 1, '2019-07-30', 1),
                                                                              (337, 'admin', 1, '2019-08-06', 1),
                                                                              (338, 'admin', 1, '2019-08-13', 1),
                                                                              (339, 'admin', 1, '2019-08-20', 1),
                                                                              (340, 'admin', 1, '2019-08-27', 1),
                                                                              (341, 'admin', 1, '2019-09-03', 1),
                                                                              (342, 'admin', 1, '2019-09-10', 1),
                                                                              (343, 'admin', 1, '2019-09-17', 1),
                                                                              (344, 'admin', 1, '2019-09-24', 1),
                                                                              (345, 'admin', 1, '2019-10-01', 1),
                                                                              (346, 'admin', 1, '2019-10-08', 1),
                                                                              (347, 'admin', 1, '2019-10-15', 1),
                                                                              (348, 'admin', 1, '2019-10-22', 1),
                                                                              (349, 'admin', 1, '2019-10-29', 1),
                                                                              (350, 'admin', 1, '2019-11-05', 1),
                                                                              (351, 'admin', 1, '2019-11-12', 1),
                                                                              (352, 'admin', 1, '2019-11-19', 1),
                                                                              (353, 'admin', 1, '2019-11-26', 1),
                                                                              (354, 'admin', 1, '2019-12-03', 1),
                                                                              (355, 'admin', 1, '2019-12-10', 1),
                                                                              (356, 'admin', 1, '2019-12-17', 1),
                                                                              (357, 'admin', 1, '2019-12-24', 1),
                                                                              (358, 'admin', 1, '2018-12-31', 2),
                                                                              (359, 'admin', 1, '2019-01-07', 2),
                                                                              (360, 'admin', 1, '2019-01-14', 2),
                                                                              (361, 'admin', 1, '2019-01-21', 2),
                                                                              (362, 'admin', 1, '2019-01-28', 2),
                                                                              (363, 'admin', 1, '2019-02-04', 2),
                                                                              (364, 'admin', 1, '2019-02-11', 2),
                                                                              (365, 'admin', 1, '2019-02-18', 2),
                                                                              (366, 'admin', 1, '2019-02-25', 2),
                                                                              (367, 'admin', 1, '2019-03-04', 2),
                                                                              (368, 'admin', 1, '2019-03-11', 2),
                                                                              (369, 'admin', 1, '2019-03-18', 2),
                                                                              (370, 'admin', 1, '2019-03-25', 2),
                                                                              (371, 'admin', 1, '2019-04-01', 2),
                                                                              (372, 'admin', 1, '2019-04-08', 2),
                                                                              (373, 'admin', 1, '2019-04-15', 2),
                                                                              (374, 'admin', 1, '2019-04-22', 2),
                                                                              (375, 'admin', 1, '2019-04-29', 2),
                                                                              (376, 'admin', 1, '2019-05-06', 2),
                                                                              (377, 'admin', 1, '2019-05-13', 2),
                                                                              (378, 'admin', 1, '2019-05-20', 2),
                                                                              (379, 'admin', 1, '2019-05-27', 2),
                                                                              (380, 'admin', 1, '2019-06-03', 2),
                                                                              (381, 'admin', 1, '2019-06-10', 2),
                                                                              (382, 'admin', 1, '2019-06-17', 2),
                                                                              (383, 'admin', 1, '2019-06-24', 2),
                                                                              (384, 'admin', 1, '2019-07-01', 2),
                                                                              (385, 'admin', 1, '2019-07-08', 2),
                                                                              (386, 'admin', 1, '2019-07-15', 2),
                                                                              (387, 'admin', 1, '2019-07-22', 2),
                                                                              (388, 'admin', 1, '2019-07-29', 2),
                                                                              (389, 'admin', 1, '2019-08-05', 2),
                                                                              (390, 'admin', 1, '2019-08-12', 2),
                                                                              (391, 'admin', 1, '2019-08-19', 2),
                                                                              (392, 'admin', 1, '2019-08-26', 2),
                                                                              (393, 'admin', 1, '2019-09-02', 2),
                                                                              (394, 'admin', 1, '2019-09-09', 2),
                                                                              (395, 'admin', 1, '2019-09-16', 2),
                                                                              (396, 'admin', 1, '2019-09-23', 2),
                                                                              (397, 'admin', 1, '2019-09-30', 2),
                                                                              (398, 'admin', 1, '2019-10-07', 2),
                                                                              (399, 'admin', 1, '2019-10-14', 2),
                                                                              (400, 'admin', 1, '2019-10-21', 2),
                                                                              (401, 'admin', 1, '2019-10-28', 2),
                                                                              (402, 'admin', 1, '2019-11-04', 2),
                                                                              (403, 'admin', 1, '2019-11-11', 2),
                                                                              (404, 'admin', 1, '2019-11-18', 2),
                                                                              (405, 'admin', 1, '2019-11-25', 2),
                                                                              (406, 'admin', 1, '2019-12-02', 2),
                                                                              (407, 'admin', 1, '2019-12-09', 2),
                                                                              (408, 'admin', 1, '2019-12-16', 2),
                                                                              (409, 'admin', 1, '2019-12-23', 2),
                                                                              (712, 'admin', 2, '2019-01-09', 2),
                                                                              (713, 'admin', 2, '2019-01-11', 2),
                                                                              (714, 'admin', 2, '2019-01-13', 2),
                                                                              (715, 'admin', 2, '2019-01-15', 2),
                                                                              (716, 'pepe', 5, '2019-01-17', 1);



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
                                                                          ('2018-11-15', 25, 5, 3),
                                                                          ('2018-11-16', 1, 1, NULL),
                                                                          ('2018-11-16', 2, 1, NULL),
                                                                          ('2018-11-16', 3, 1, NULL),
                                                                          ('2018-11-16', 4, 1, NULL),
                                                                          ('2018-11-16', 5, 1, NULL),
                                                                          ('2018-11-16', 6, 1, NULL),
                                                                          ('2018-11-16', 7, 1, NULL),
                                                                          ('2018-11-16', 8, 1, NULL),
                                                                          ('2018-11-16', 9, 1, NULL),
                                                                          ('2018-11-16', 10, 1, NULL),
                                                                          ('2018-11-16', 11, 1, NULL),
                                                                          ('2018-11-16', 12, 1, NULL),
                                                                          ('2018-11-16', 13, 1, NULL),
                                                                          ('2018-11-16', 14, 1, NULL),
                                                                          ('2018-11-16', 15, 1, NULL),
                                                                          ('2018-11-16', 16, 1, NULL),
                                                                          ('2018-11-16', 17, 2, NULL),
                                                                          ('2018-11-16', 18, 2, NULL),
                                                                          ('2018-11-16', 19, 2, NULL),
                                                                          ('2018-11-16', 20, 2, NULL),
                                                                          ('2018-11-16', 21, 2, NULL),
                                                                          ('2018-11-16', 22, 2, NULL),
                                                                          ('2018-11-16', 23, 2, NULL),
                                                                          ('2018-11-16', 24, 2, NULL),
                                                                          ('2018-11-16', 25, 2, NULL);

-- INSERTS EN TABLA ENFRENTAMIENTO
INSERT INTO ENFRENTAMIENTO (ID, GRUPO_ID, RESULTADO, PAREJA_1, PAREJA_2, RESERVA_ID) VALUES
                                                                                              (1, 1, '6-4/6-3/0-0', 1, 6, 17),
                                                                                              (2, 1, '6-4/6-3/0-0', 1, 7, 18),
                                                                                              (3, 1, '6-4/6-3/0-0', 1, 8, 19),
                                                                                              (4, 1, '6-4/6-3/0-0', 1, 9, 20),
                                                                                              (5, 1, '6-4/6-3/0-0', 1, 14, 21),
                                                                                              (6, 1, '6-4/6-3/0-0', 1, 15, 22),
                                                                                              (7, 1, '6-4/3-6/6-2', 1, 16, 23),
                                                                                              (8, 1, '6-4/6-4/0-0', 6, 7, 24),
                                                                                              (9, 1, '6-4/6-3/0-0', 6, 8, 712),
                                                                                              (10, 1, '6-4/6-3/0-0', 6, 9, 712),
                                                                                              (11, 1, '6-4/6-3/0-0', 6, 14, 712),
                                                                                              (12, 1, '6-4/6-3/0-0', 6, 15, 712),
                                                                                              (13, 1, '6-4/6-3/0-0', 6, 16, 712),
                                                                                              (14, 1, '6-4/6-3/0-0', 7, 8, 712),
                                                                                              (15, 1, '6-4/6-3/0-0', 7, 9, 712),
                                                                                              (16, 1, '6-4/6-3/0-0', 7, 14, 712),
                                                                                              (17, 1, '6-4/6-3/0-0', 7, 15, 712),
                                                                                              (18, 1, '6-4/6-3/0-0', 7, 16, 712),
                                                                                              (19, 1, '6-4/6-3/0-0', 8, 9, 712),
                                                                                              (20, 1, '6-4/6-3/0-0', 8, 14, 712),
                                                                                              (21, 1, '6-4/6-3/0-0', 8, 15, 712),
                                                                                              (22, 1, '6-4/6-3/0-0', 8, 16, 712),
                                                                                              (23, 1, '6-4/6-3/0-0', 9, 14, 712),
                                                                                              (24, 1, '6-4/6-3/0-0', 9, 15, 712),
                                                                                              (25, 1, '6-4/6-3/0-0', 9, 16, 712),
                                                                                              (26, 1, '6-4/6-3/0-0', 14, 15, 712),
                                                                                              (27, 1, '6-4/6-3/0-0', 14, 16, 712),
                                                                                              (28, 1, '6-4/6-3/0-0', 15, 16, 712),
                                                                                              (29, 2, '6-4/3-6/6-2', 2, 3, 26),
                                                                                              (30, 2, '6-4/6-3/0-0', 2, 4, 27),
                                                                                              (31, 2, '6-4/6-3/0-0', 2, 5, 28),
                                                                                              (32, 2, '6-4/6-3/0-0', 2, 10, 29),
                                                                                              (33, 2, '6-4/6-3/0-0', 2, 11, 30),
                                                                                              (34, 2, '6-4/6-3/0-0', 2, 12, 31),
                                                                                              (35, 2, '6-4/6-3/0-0', 2, 13, 32),
                                                                                              (36, 2, '6-4/2-6/6-4', 3, 4, 33),
                                                                                              (37, 2, '6-4/6-3/0-0', 3, 5, 34),
                                                                                              (38, 2, '6-4/6-3/0-0', 3, 10, 712),
                                                                                              (39, 2, '6-4/6-3/0-0', 3, 11, 712),
                                                                                              (40, 2, '6-4/6-3/0-0', 3, 12, 712),
                                                                                              (41, 2, '6-4/6-3/0-0', 3, 13, 712),
                                                                                              (42, 2, '6-4/6-3/0-0', 4, 5, 712),
                                                                                              (43, 2, '6-4/6-3/0-0', 4, 10, 712),
                                                                                              (44, 2, '6-4/6-3/0-0', 4, 11, 712),
                                                                                              (45, 2, '6-4/6-3/0-0', 4, 12, 712),
                                                                                              (46, 2, '6-4/6-3/0-0', 4, 13, 712),
                                                                                              (47, 2, '6-4/6-3/0-0', 5, 10, 712),
                                                                                              (48, 2, '6-4/6-3/0-0', 5, 11, 712),
                                                                                              (49, 2, '6-4/6-3/0-0', 5, 12, 712),
                                                                                              (50, 2, '6-4/6-3/0-0', 5, 13, 712),
                                                                                              (51, 2, '6-4/6-3/0-0', 10, 11, 712),
                                                                                              (52, 2, '6-4/6-3/0-0', 10, 12, 712),
                                                                                              (53, 2, '6-4/6-3/0-0', 10, 13, 712),
                                                                                              (54, 2, '6-4/6-3/0-0', 11, 12, 712),
                                                                                              (55, 2, '6-4/6-3/0-0', 11, 13, 712),
                                                                                              (56, 2, NULL, 12, 13, 712),
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
                                                                                              (92, 3, NULL, 24, 25, NULL),

                                                                                              (93, 1, '6-4/6-3/0-0', 1, 16, 713),
                                                                                              (94, 1, '6-4/6-3/0-0', 6, 14, 713),
                                                                                              (95, 1, '6-4/6-3/0-0', 7, 15, 713),
                                                                                              (96, 1, '6-4/6-3/0-0', 8, 9, 713),

                                                                                              (97, 1, '6-4/6-3/0-0', 1, 6, 714),
                                                                                              (98, 1, '6-4/6-3/0-0', 7, 8, 714),


                                                                                              (100, 2, '6-4/6-3/0-0', 2, 13, 715),
                                                                                              (101, 2, NULL, 3, 11, 715),
                                                                                              (102, 2, NULL, 4, 12, NULL),
                                                                                              (103, 2, NULL, 5, 10, NULL),

                                                                                              (104, 1, NULL, 1, 7, 715);





-- INSERTS EN TABLA PARTIDO
INSERT INTO PARTIDO (ID, FECHA, RESERVA_ID, PISTA_ID, HORARIO_ID, INSCRIPCIONES) VALUES
                                                                                        (1, '2018-11-22', NULL, 5, 1, 1),
                                                                                        (2, '2018-11-26', 5, 5, 1, 4),
                                                                                        (3, '2018-11-27', NULL, 1, 4, 2),
                                                                                        (4, '2018-11-28', NULL, 1, 2, 1),
                                                                                        (5, '2018-11-29', NULL, 2, 5, 3),
                                                                                        (6, '2018-12-01', NULL, 3, 2, 0),
                                                                                        (7, '2019-01-19', NULL, 1, 1, 0),
                                                                                        (8, '2019-01-20', NULL, 1, 1, 0),
                                                                                        (9, '2019-01-20', NULL, 2, 1, 0),
                                                                                        (10, '2019-01-22', NULL, 1, 4, 0);

-- INSERTS EN TABLA USUARIO_PARTIDO
INSERT INTO USUARIO_PARTIDO (ID, USUARIO_LOGIN, PARTIDO_ID) VALUES  (1, 'pepe', 1),
                                                                    (2, 'lorenzo', 2),
                                                                    (3, 'maria', 2),
                                                                    (4, 'carmen', 2),
                                                                    (5, 'miguel', 2),
                                                                    (6, 'sara', 3),
                                                                    (7, 'pepe', 3),
                                                                    (8, 'pepe', 4),
                                                                    (9, 'paula', 5),
                                                                    (10, 'jose', 5),
                                                                    (11, 'guillermo', 5);

-- INSERTS EN TABLA ESCUELA
INSERT INTO ESCUELA (ID, NOMBRE, DIA, PISTA_ID, HORARIO_ID, INSCRIPCIONES) VALUES
                                                                            (1, 'Clase Saque', 'Monday', 1, 2, 1),
                                                                            (2, 'Clase Golpeo', 'Tuesday', 1, 1, 4),
                                                                            (3, 'Clase Dejadas', 'Friday', 1, 4, 0),
                                                                            (4, 'Clase Volea', 'Friday', 4, 7, 0);


-- INSERTS EN TABLA USUARIO_ESCUELA
INSERT INTO USUARIO_ESCUELA (ID, USUARIO_LOGIN, ESCUELA_ID) VALUES
                                                              (1, 'adrian', 2),
                                                              (2, 'pepe', 2),
                                                              (3, 'agustin', 2),
                                                              (4, 'alejandra', 2),
                                                              (5, 'pepe', 1);







INSERT INTO NOTICIA (ID, TITULO, DESCRIPCION, LINK) VALUES
                                                        (1, 'Nueva web!', 'Os presentamos la nueva web del club, esperamos que os guste!', '../Controllers/INDEX_Controller.php'),
                                                        (2, 'Nuevo partido', 'Nuevo partido 2019-01-20 1, pista: 1', '../Controller/INSCRIBIRSE_PARTIDOS_Controller.php'),
                                                        (3, 'Nuevo partido', 'Nuevo partido 2019-01-20 1, pista: 2', '../Controller/INSCRIBIRSE_PARTIDOS_Controller.php'),
                                                        (4, 'Nuevo campeonato', 'Nuevo campeonato Campeonato General, limite de inscripcion hasta: 2019-01-01', '../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS'),
                                                        (5, 'Nuevo partido', 'Nuevo partido 2019-01-22 4, pista: 1', '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'),
                                                        (6, 'Nuevo campeonato', 'Nuevo campeonato Campeonato Norte, lÃ­mite de inscripcion hasta: 2019-01-31', '../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS'),
                                                        (7, 'Nueva clase', 'Nueva clase Friday 7, pista: 4', '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php');
-- INSERT EN TABLA DE FINALISTA CAMPEONATO

INSERT INTO FINALISTA_CAMPEONATO (`GRUPO_ID`, `PAREJA_ID`, `ETAPA`, `PUNTOS`, `FECHA`) VALUES   
                                                                                                (1, 9, 'C', 4, '2019-01-10'),
                                                                                                (1, 14, 'C', 6, '2019-01-10'),
                                                                                                (1, 15, 'C', 5, '2019-01-10'),
                                                                                                (1, 16, 'C', 7, '2019-01-10'),

                                                                                                (1, 6, 'S', 0, '2019-01-12'),
                                                                                                (1, 8, 'S', 0, '2019-01-12'),

                                                                                                (1, 1, 'F', 0, '2019-01-13'), 
                                                                                                (1, 7, 'F', 0, '2019-01-13'),                                                                                                

                                                                                                (2, 2, 'C', 0, '2019-01-14'),
                                                                                                (2, 3, 'C', 1, '2019-01-14'),
                                                                                                (2, 4, 'C', 2, '2019-01-14'),
                                                                                                (2, 5, 'C', 3, '2019-01-14'),
                                                                                                (2, 10, 'C', 4, '2019-01-14'),
                                                                                                (2, 11, 'C', 6, '2019-01-14'),
                                                                                                (2, 12, 'C', 5, '2019-01-14'),
                                                                                                (2, 13, 'C', 7, '2019-01-14');



