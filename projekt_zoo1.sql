DROP TABLE IF EXISTS Kwatera CASCADE;
DROP TABLE IF EXISTS Lokalizacja CASCADE;
DROP TABLE IF EXISTS Pracownik CASCADE;
DROP TABLE IF EXISTS Projekty CASCADE;
DROP TABLE IF EXISTS Specjalnosci CASCADE;
DROP TABLE IF EXISTS Zadania CASCADE;
DROP TABLE IF EXISTS Zespol CASCADE;

CREATE TABLE Lokalizacja (
    ID_lokalizacji SERIAL PRIMARY KEY,
    Adres varchar(50)  NOT NULL
);


CREATE TABLE Kwatera (
    ID_kwatery SERIAL PRIMARY KEY,
    ID_lokalizacji int  REFERENCES Lokalizacja,
    Nazwa varchar(25) NOT NULL
);


CREATE TABLE Pracownik (
    ID_pracownika SERIAL PRIMARY KEY,
    Imie varchar(15)  NOT NULL,
    Nazwisko varchar(20)  NOT NULL,
    haslo varchar(20) DEFAULT 'ogrod'
);


CREATE TABLE Projekty (
    ID_projektu SERIAL PRIMARY KEY,
    ID_kwatery int  REFERENCES Kwatera NOT NULL,
    Nazwa varchar(20) NOT NULL
);


CREATE TABLE Specjalnosci (
    ID_specjalnosci SERIAL PRIMARY KEY,
    Nazwa varchar(20)  NOT NULL
);


CREATE TABLE Zadania (
    ID_zadania SERIAL PRIMARY KEY,
    DataZ date  NOT NULL,
    ID_pracownika int  REFERENCES Pracownik NOT NULL,
    ID_projektu int REFERENCES Projekty NOT NULL,
    ID_specjalnosci int REFERENCES Specjalnosci NOT NULL
);


CREATE TABLE Zespol (
    ID_pracownika int REFERENCES Pracownik NOT NULL,
    ID_specjalnosci int REFERENCES Specjalnosci NOT NULL
);
