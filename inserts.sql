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
                                                                                ("sebastian","jose", "Jose", "Garcia Perez", "Hombre", 2),
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
                                                                                ("miguelan","miguelan", "Miguel Angel", "Castro Santana", "Hombre", 2);



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
                                                              (16,"lucas", "ian", "lucas"), 
                                                              (17,"arturo", "rafael", "arturo"), 
                                                              (18,"mario", "nico", "mario"), 
                                                              (19,"jesus", "miguelan", "jesus");
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
                                                        (6, '16:30', '18:00');
-- INSERTS EN TABLA CAMPEONATO
INSERT INTO CAMPEONATO (ID, NOMBRE, FECHA) VALUES   (1, "Campeonato Provincial", '2018-11-18'),
                                                    (2, "Campeonato Autonomico", '2018-12-10'),
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


-- INSERTS EN TABLA CAMPEONATO_CATEGORIA
INSERT INTO CAMPEONATO_CATEGORIA (ID, CAMPEONATO_ID, CATEGORIA_ID) VALUES  (1, 1, 1),
                                                                    (2, 1, 2),
                                                                    (3, 1, 3),
                                                                    (4, 1, 4),
                                                                    (5, 1, 5),
                                                                    (6, 1, 6),
                                                                    (7, 1, 7),
                                                                    (8, 2, 1),
                                                                    (9, 2, 2),
                                                                    (10, 2, 3),
                                                                    (11, 2, 4),
                                                                    (12, 3, 1),
                                                                    (13, 3, 3),
                                                                    (14, 3, 5),
                                                                    (15, 3, 7);

-- INSERTS EN TABLA GRUPO
INSERT INTO GRUPO (ID, NOMBRE, CAMPEONATO_ID, CATEGORIA_ID) VALUES  (1, '1', 1, 1),
                                                                    (2, '2', 1, 1),
                                                                    (3, '1', 1, 3),
                                                                    (4, '1', 1, 4),
                                                                    (5, '1', 1, 5),
                                                                    (6, '1', 1, 6),
                                                                    (7, '1', 1, 7),
                                                                    (8, '1', 2, 1),
                                                                    (9, '1', 2, 2),
                                                                    (10, '1', 2, 3),
                                                                    (11, '1', 2, 4),
                                                                    (12, '1', 3, 1),
                                                                    (13, '1', 3, 3),
                                                                    (14, '1', 3, 5),
                                                                    (15, '1', 3, 7);
                                                                    

-- INSERTS EN TABLA INSCRIPCION
  INSERT INTO INSCRIPCION (FECHA, PAREJA_ID, CAM_CAT_ID, GRUPO_ID)  VALUES  ('2018-11-01','1', '1', NULL),
                                                                            ('2018-11-01','2', '1', NULL),
                                                                           ('2018-11-01','3', '1', NULL),
                                                                           ('2018-11-01','4', '1', NULL),
                                                                           ('2018-11-01','5', '1', NULL),
                                                                           ('2018-11-01','6', '1', NULL),
                                                                           ('2018-11-01','7', '1', NULL),
                                                                           ('2018-11-01','8', '1', NULL),
                                                                           ('2018-11-01','9', '1', NULL),
                                                                           ('2018-11-01','10', '1', NULL),
                                                                           ('2018-11-01','11', '1', NULL),
                                                                           ('2018-11-01','12', '1', NULL),
                                                                           ('2018-11-01','13', '1', NULL),
                                                                           ('2018-11-01','14', '1', NULL),
                                                                           ('2018-11-01','15', '1', NULL),
                                                                           ('2018-11-01','16', '1', NULL),
                                                                           ('2018-11-01','17', '1', NULL),
                                                                           ('2018-11-01','18', '1', NULL),
                                                                           ('2018-11-01','19', '1', NULL);

-- INSERTS EN TABLA RESERVA
INSERT INTO RESERVA (ID, USUARIO_LOGIN, PISTA_ID, FECHA, HORARIO_ID) VALUES   (1, "pepe", 1, '2018-11-26', 1),
                                                                              (2, "carlos", 2, '2018-11-26', 1),
                                                                              (3, "carmen", 3, '2018-11-26', 1),
                                                                              (4, "lucas", 4, '2018-11-26', 1),
                                                                              (5, "admin", 5, '2018-11-26', 1),
                                                                              (6, "nuria", 1, '2018-11-28', 2),
                                                                              (7, "sara", 2, '2018-11-29', 1),
                                                                              (8, "pepe", 1, '2018-11-20', 1),
                                                                              (9, "carlos", 2, '2018-11-20', 1),
                                                                              (10, "carmen", 3, '2018-11-20', 1),
                                                                              (11, "lucas", 4, '2018-11-20', 1),
                                                                              (12, "admin", 5, '2018-11-20', 1);



-- INSERTS EN TABLA ENFRENTAMIENTO
INSERT INTO ENFRENTAMIENTO (ID, GRUPO_ID, RESULTADO, PAREJA_1, PAREJA_2, RESERVA_ID) VALUES   (1,  1, "6-4/4-6/6-3", 1, 2, 8),
                                                                                              (2,  1, "6-4/4-6/6-3", 1, 3, 8),
                                                                                              (3,  1, "6-4/4-6/6-3", 1, 4, 8),
                                                                                              (4,  1, "6-4/4-6/6-3", 1, 5, 8),
                                                                                              (5,  1, "6-4/4-6/6-3", 1, 6, 8),
                                                                                              (6,  1, "6-4/4-6/6-3", 2, 7, 8),
                                                                                              (7,  1, "6-4/4-6/6-3", 2, 9, 8),
                                                                                              (8,  2, "6-4/4-6/6-3", 2, 3, 8),
                                                                                              (9,  2, "6-4/4-6/6-3", 2, 4, 8),
                                                                                              (10,  2,"6-4/4-6/6-3", 3, 5, 8),
                                                                                              (11,  2, "6-4/4-6/6-3", 3, 6, 8),
                                                                                              (12,  2, "6-4/4-6/6-3", 3, 7, 8);
-- INSERTS EN TABLA HUECO

-- INSERTS EN TABLA CLASIFICACION
INSERT INTO CLASIFICACION (ID, PAREJA_ID, GRUPO_ID, PUNTOS) VALUES            (1,  1, 1, 0),
                                                                              (2,  2, 1, 0),
                                                                              (3,  3, 1, 0),
                                                                              (4,  4, 1, 0),
                                                                              (5,  5, 1, 0),
                                                                              (6,  6, 1, 0),
                                                                              (7,  7, 1, 0),
                                                                              (8,  8, 1, 0),
                                                                              (9,  9, 1, 0),
                                                                              (10,  10, 1, 0),
                                                                              (11,  11, 1, 0),
                                                                              (12,  12, 1, 0),
                                                                              (13,  1, 2, 0),
                                                                              (14,  2, 2, 0),
                                                                              (15,  3, 2, 0),
                                                                              (16,  4, 2, 0),
                                                                              (17,  5, 2, 0),
                                                                              (18,  6, 2, 0),
                                                                              (19,  7, 2, 0),
                                                                              (20,  8, 2, 0),
                                                                              (21,  9, 2, 0),
                                                                              (22,  10, 2, 0),
                                                                              (23,  11, 2, 0),
                                                                              (24,  12, 2, 0);


-- INSERTS EN TABLA PARTIDO
INSERT INTO PARTIDO (ID, FECHA, RESERVA_ID, PISTA_ID, HORARIO_ID, INSCRIPCIONES) VALUES   (1, '2018-11-22', NULL, 5, 1, 1),
                                                                                          (2, '2018-11-26', 5, 5, 1, 4),
                                                                                          (3, '2018-11-27', NULL, 1, 4, 2),
                                                                                          (4, '2018-11-28', NULL, 1, 2, 1),
                                                                                          (5, '2018-11-29', NULL, 2, 5, 3),
                                                                                          (6, '2018-11-30', NULL, 3, 2, 0);


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

