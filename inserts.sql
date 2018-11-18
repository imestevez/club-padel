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
                                                                                ("francisco","francisco", "Francisco", "Torres Rios", "Hombre", 2);

-- INSERTS DE TABLA PAREJA
INSERT INTO PAREJA (ID, JUGADOR_1, JUGADOR_2, CAPITAN) VALUES (0,"pepe", "carlos", "pepe"),
                                                              (0,"maria", "lucia", "maria"),
                                                              (0,"jose", "lucas", "jose"),
                                                              (0,"sara", "carmen", "sara"),
                                                              (0,"agustin", "felix", "agustin"),
                                                              (0,"alfonso", "jaime", "alfonso"),
                                                              (0,"alicia", "rocio", "alicia"),
                                                              (0,"miguel", "lorenzo", "miguel"),
                                                              (0,"gillermo", "marcos", "gillermo"),
                                                              (0,"paula", "alejandra", "paula"),
                                                              (0,"juan", "hector", "juan"),
                                                              (0,"trinidad", "roberto", "trinidad"),
                                                              (0,"francisco", "nuria", "francisco") ;
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
                                                    (3, "Campeonato Inernacional", '2019-01-15');
-- INSERTS EN TABLA CATEGORIA
INSERT INTO CATEGORIA (ID, NIVEL, GENERO) VALUES  (1, 1, "Masculina"),
                                                  (2, 1, "Femenina"),
                                                  (3, 2, "Masculina"),
                                                  (4, 2, "Femenina"),
                                                  (5, 3, "Masculina"),
                                                  (6, 3, "Femenina"),
                                                  (7, 4, "Mixta");
-- INSERTS EN TABLA CAMPEONATO_CATEGORIA

-- INSERTS EN TABLA GRUPO

-- INSERTS EN TABLA INSCRIPCION

-- INSERTS EN TABLA RESERVA
INSERT INTO RESERVA (ID, USUARIO_LOGIN, PISTA_ID, FECHA, HORARIO_ID) VALUES   (1, "pepe", 1, '2018-11-26', 1),
                                                                              (2, "carlos", 2, '2018-11-26', 1),
                                                                              (3, "carmen", 3, '2018-11-26', 1),
                                                                              (4, "lucas", 4, '2018-11-26', 1),
                                                                              (5, "admin", 5, '2018-11-26', 1),
                                                                              (6, "nuria", 1, '2018-11-28', 2),
                                                                              (7, "sara", 2, '2018-11-29', 1),
                                                                              (8, "pepe", 1, '2018-11-22', 1),
                                                                              (9, "carlos", 2, '2018-11-22', 1),
                                                                              (10, "carmen", 3, '2018-11-22', 1),
                                                                              (11, "lucas", 4, '2018-11-22', 1),
                                                                              (12, "admin", 5, '2018-11-22', 1);



-- INSERTS EN TABLA ENFRENTAMIENTO

-- INSERTS EN TABLA HUECO

-- INSERTS EN TABLA CLASIFICACION

-- INSERTS EN TABLA CATEGORIA_CLASIFICACION

-- INSERTS EN TABLA GRUPO_CLASIFICACION

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
