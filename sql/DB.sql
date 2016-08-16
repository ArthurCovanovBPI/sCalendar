/*mysql -uroot -ppassword*/
/*USE bpi_calendar;*/
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS datesManif;
DROP TABLE IF EXISTS manifestation;
/*DROP TABLE IF EXISTS reservation;*/
DROP TABLE IF EXISTS lieu;
DROP TABLE IF EXISTS espace;
DROP TABLE IF EXISTS responsable;
DROP TABLE IF EXISTS recurrence_manifestation;
DROP TABLE IF EXISTS type_manifestation;
DROP TABLE IF EXISTS status_manifestation;

CREATE TABLE status_manifestation
(
	ID TINYINT NOT NULL AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE type_manifestation
(
	ID TINYINT NOT NULL AUTO_INCREMENT,
	type VARCHAR(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE recurrence_manifestation
(
	ID TINYINT NOT NULL AUTO_INCREMENT,
	recurrence VARCHAR(255),
	PRIMARY KEY (ID)
);

CREATE TABLE responsable
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(255) NOT NULL,
	rightsFlags TINYINT NOT NULL DEFAULT 0,
	PRIMARY KEY (ID, nom)
);

CREATE TABLE espace
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	espace VARCHAR(255) NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE lieu
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	lieu VARCHAR(255) NOT NULL,
	espace_ID BIGINT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (espace_ID) REFERENCES espace(ID)
);

/*CREATE TABLE reservation
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	lieu_ID BIGINT NOT NULL,
	debut_reservation_year INT NOT NULL, debut_reservation_month TINYINT NOT NULL, debut_reservation_day TINYINT NOT NULL, debut_reservation_hour TINYINT NOT NULL, debut_reservation_minute TINYINT NOT NULL,
	fin_reservation_year INT NOT NULL, fin_reservation_month TINYINT NOT NULL, fin_reservation_day TINYINT NOT NULL, fin_reservation_hour TINYINT NOT NULL, fin_reservation_minute TINYINT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (lieu_ID) REFERENCES lieu(ID)
);*/

CREATE TABLE manifestation
(
	ID BIGINT NOT NULL AUTO_INCREMENT,/*
	debut_manif_year INT NOT NULL, debut_manif_month TINYINT NOT NULL, debut_manif_day TINYINT NOT NULL, debut_manif_hour TINYINT NOT NULL, debut_manif_minute TINYINT NOT NULL,
	fin_manif_year INT NOT NULL, fin_manif_month TINYINT NOT NULL, fin_manif_day TINYINT NOT NULL, fin_manif_hour TINYINT NOT NULL, fin_manif_minute TINYINT NOT NULL,*/
	recurrence_manifestation_ID TINYINT NOT NULL,
	fin_recurence_year INT NOT NULL DEFAULT -1, fin_recurence_month TINYINT NOT NULL DEFAULT -1, fin_recurence_day TINYINT NOT NULL DEFAULT -1,
	status_manifestation_ID TINYINT NOT NULL,
	type_manifestation_ID TINYINT NOT NULL,
	intitule VARCHAR(255) NOT NULL,
	responsable_ID BIGINT NOT NULL,/*
	reservation_ID BIGINT,*/
	observations TEXT,
	evenement TEXT,
	PRIMARY KEY (ID),
	FOREIGN KEY (status_manifestation_ID) REFERENCES status_manifestation(ID),
	FOREIGN KEY (type_manifestation_ID) REFERENCES type_manifestation(ID),
	FOREIGN KEY (recurrence_manifestation_ID) REFERENCES recurrence_manifestation(ID),
	FOREIGN KEY (responsable_ID) REFERENCES responsable(ID)/*,
	FOREIGN KEY (reservation_ID) REFERENCES reservation(ID)*/
);

CREATE TABLE datesManif
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	manifestation_ID BIGINT NOT NULL,/*
	debut_manif_year INT NOT NULL, debut_manif_month TINYINT NOT NULL, debut_manif_day TINYINT NOT NULL, debut_manif_hour TINYINT NOT NULL, debut_manif_minute TINYINT NOT NULL,
	fin_manif_year INT NOT NULL, fin_manif_month TINYINT NOT NULL, fin_manif_day TINYINT NOT NULL, fin_manif_hour TINYINT NOT NULL, fin_manif_minute TINYINT NOT NULL,*/
	debut_manif BIGINT NOT NULL,
	fin_manif BIGINT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (manifestation_ID) REFERENCES manifestation(ID)
);

CREATE TABLE reservation/*_tst*/
(
	ID BIGINT NOT NULL AUTO_INCREMENT,
	lieu_ID BIGINT NOT NULL,
	dates_manifestation_ID BIGINT NOT NULL,
	debut_reservation BIGINT NOT NULL,
	fin_reservation BIGINT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (lieu_ID) REFERENCES lieu(ID),
	FOREIGN KEY (dates_manifestation_ID) REFERENCES datesManif(ID)
);

INSERT INTO status_manifestation(status) VALUES ('Confirmée');
INSERT INTO status_manifestation(status) VALUES ('En projet');
INSERT INTO status_manifestation(status) VALUES ('Annulée');

/*INSERT INTO type_manifestation(type) VALUES ('Manifestation normale (envoi à la presse)');
INSERT INTO type_manifestation(type) VALUES ('Réunion privée (pas d''envoi à la presse)');*/
INSERT INTO type_manifestation(type) VALUES ('Manifestation publique');
INSERT INTO type_manifestation(type) VALUES ('Manfestation / réunion interne');
INSERT INTO type_manifestation(type) VALUES ('Administratif (pas d''envoi à la presse)');
INSERT INTO type_manifestation(type) VALUES ('RH (pas d''envoi à la presse)');
INSERT INTO type_manifestation(type) VALUES ('Financier (pas d''envoi à la presse)');
INSERT INTO type_manifestation(type) VALUES ('Évènement de type calendaire (vacances, jours fériés)');

INSERT INTO recurrence_manifestation(recurrence) VALUES (NULL);
INSERT INTO recurrence_manifestation(recurrence) VALUES ('Quotidien');
INSERT INTO recurrence_manifestation(recurrence) VALUES ('Hebdomadaire');
INSERT INTO recurrence_manifestation(recurrence) VALUES ('Bimensuel');
INSERT INTO recurrence_manifestation(recurrence) VALUES ('Mensuel');
INSERT INTO recurrence_manifestation(recurrence) VALUES ('Trimestriel');

INSERT INTO espace(espace) VALUES ('Espaces Centre');
INSERT INTO espace(espace) VALUES ('Espaces BPI');
INSERT INTO espace(espace) VALUES ('Hors les murs');
INSERT INTO espace(espace) VALUES ('Atelier');

INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest1', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest2', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest3', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest4', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest5', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest6', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest7', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest8', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest9', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest10', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest11', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest12', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest13', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest14', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest15', 1);
INSERT INTO lieu(lieu, espace_ID) VALUES ('CentreTest16', 1);

INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest1', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest2', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest3', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest4', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest5', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest6', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest7', 2);
INSERT INTO lieu(lieu, espace_ID) VALUES ('BPITest8', 2);

INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest1', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest2', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest3', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest4', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest5', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest6', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest7', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest8', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest9', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest10', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest11', 3);
INSERT INTO lieu(lieu, espace_ID) VALUES ('ExterieurTest12', 3);

INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest1', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest2', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest3', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest4', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest5', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest6', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest7', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest8', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest9', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest10', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest11', 4);
INSERT INTO lieu(lieu, espace_ID) VALUES ('AtelierTest12', 4);

INSERT INTO responsable(nom) VALUES ('RespoTest1');
INSERT INTO responsable(nom) VALUES ('RespoTest2');
INSERT INTO responsable(nom) VALUES ('RespoTest3');
INSERT INTO responsable(nom) VALUES ('Test1');
INSERT INTO responsable(nom) VALUES ('Test2');
INSERT INTO responsable(nom) VALUES ('Test3');
INSERT INTO responsable(nom) VALUES ('Test4');
INSERT INTO responsable(nom) VALUES ('Respo1');
INSERT INTO responsable(nom) VALUES ('Respo2');
INSERT INTO responsable(nom) VALUES ('Respo3');
INSERT INTO responsable(nom) VALUES ('Respo4');

/*INSERT INTO reservation
(
	lieu_ID,
	debut_reservation,
	fin_reservation
)
VALUES
(
	1,
	2016, 1, 1, 10, 0,
	2016, 1, 1, 12, 0
);*/

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	2,
	'tst1',
	1,
	'Observation TST1',
	'Evenement TST1'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	1,
	201601011100,
	201601011300
);

INSERT INTO reservation/*_tst*/
(
	lieu_ID,
	dates_manifestation_ID,
	debut_reservation,
	fin_reservation
)
VALUES
(
	1,
	1,
	201601011000,
	201601011200
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	1,
	201601011500,
	201601011600
);

INSERT INTO reservation/*_tst*/
(
	lieu_ID,
	dates_manifestation_ID,
	debut_reservation,
	fin_reservation
)
VALUES
(
	1,
	1,
	201601011500,
	201601011600
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst2',
	1,
	'Observation TST2',
	'Evenement TST2'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	2,
	201601011000,
	201601021200
);

INSERT INTO reservation/*_tst*/
(
	lieu_ID,
	dates_manifestation_ID,
	debut_reservation,
	fin_reservation
)
VALUES
(
	2,
	3,
	201601011500,
	201601011600
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst3',
	1,
	'Observation TST3',
	'Evenement TST3'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	3,
	201512301000,
	201601021200
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst4',
	1,
	'Observation TST4',
	'Evenement TST4'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	4,
	201601051000,
	201601091200
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst5',
	1,
	'Observation TST5',
	'Evenement TST5'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	5,
	201601010800,
	201601010930
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst6',
	1,
	'Observation TST6',
	'Evenement TST6'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	6,
	201512311630,
	201601010130
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst7',
	1,
	'Observation TST7',
	'Evenement TST7'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	7,
	201512281630,
	201602100130
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst8',
	1,
	'Observation TST8',
	'Evenement TST8'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	8,
	201601111630,
	201601120730
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst9',
	1,
	'Observation TST9',
	'Evenement TST9'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	9,
	201601120400,
	201601121200
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst10',
	1,
	'Observation TST10',
	'Evenement TST10'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	10,
	201601121200,
	201601121400
);

INSERT INTO manifestation
(
	status_manifestation_ID,
	type_manifestation_ID,
	recurrence_manifestation_ID,
	intitule,
	responsable_ID,
	observations,
	evenement
)
VALUES
(
	1,
	1,
	1,
	'tst11',
	1,
	'Observation TST11',
	'Evenement TST11'
);

INSERT INTO datesManif
(
	manifestation_ID,
	debut_manif,
	fin_manif
)
VALUES
(
	11,
	201601120800,
	201601121200
);

