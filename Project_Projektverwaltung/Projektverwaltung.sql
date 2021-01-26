create database Projektverwaltung;

use Projektverwaltung;

--------------------------------------------------------------------------------------------------MITARBEITER
drop table if exists Mitarbeiter;

create table Mitarbeiter
	(PersNr integer primary key auto_increment,
     Nachname varchar (50),
	 Vorname varchar (50),
	 Geburtsdatum date,
     FK_Abteilung varchar(3)
	);

alter table Mitarbeiter add foreign key (FK_Abteilung)
	references Abteilung (Abkuerzung);

insert into Mitarbeiter (Nachname, Vorname, Geburtsdatum)
	values ('Mustermann', 'Max', '1970-01-01');
insert into Mitarbeiter (Nachname, Vorname, Geburtsdatum)
	values ('Fall', 'Clara', '1980-02-02');
insert into Mitarbeiter (Nachname, Vorname, Geburtsdatum)
	values ('Winzig', 'Willi', '1990-03-03');
insert into Mitarbeiter (Nachname, Vorname, Geburtsdatum)
	values ('Mustermann', 'Moritz', '1975-04-04');

-----------------------------------------------------------------------------------------------------ABTEILUNG
drop table if exists Abteilung;

create table Abteilung
	(Abkuerzung varchar(3) primary key,
     Beschreibung varchar(80),
     FK_Leitung integer
	);

alter table Abteilung add foreign key (FK_Leitung)
	references Mitarbeiter (PersNr);

insert into Abteilung (Abkuerzung, Beschreibung, FK_Leitung)
	values ('EK', 'Einkauf', 1);
insert into Abteilung (Abkuerzung, Beschreibung, FK_Leitung)
	values ('IT', 'Technische Infrastruktur', 2);
insert into Abteilung (Abkuerzung, Beschreibung, FK_Leitung)
	values ('PV', 'Personenverwaltung', 3);
insert into Abteilung (Abkuerzung, Beschreibung, FK_Leitung)
	values ('VK', 'Verkauf', 4);

--------------------------------------------------------------------------------------------------------PROJEKT
drop table if exists Projekt;

create table Projekt
	(ProjektNr integer primary key auto_increment,
     Beschreibung varchar(200),
	 Starttermin date,
	 Endtermin date
	);

insert into Projekt (Beschreibung, Starttermin, Endtermin)
    values ('Testprojekt', '2021-01-10', '2021-01-15');

--------------------------------------------------------------------------------------------MITARBEITER_PROJEKT
drop table if exists Mitarbeiter_Projekt;

create table Mitarbeiter_Projekt
	(ID integer primary key auto_increment,
     FK_PersNr integer,
	 FK_ProjektNr integer
	);

alter table Mitarbeiter_Projekt add foreign key (FK_PersNr)
	references Mitarbeiter (PersNr);
alter table Mitarbeiter_Projekt add foreign key (FK_ProjektNr)
	references Projekt (ProjektNr);

insert into Mitarbeiter_Projekt (FK_PersNr, FK_ProjektNr)
    values (1, 1);

