CREATE TABLE Utenti(
	id Integer AUTO_INCREMENT,
    nome varchar(25),
    cognome varchar(25),
    username varchar(20) not null,
    email varchar(40),
    password char(64) not null,
    PRIMARY KEY (id)
)

CREATE TABLE Chat(
    id Integer AUTO_INCREMENT,
    nome varchar(20),
    PRIMARY KEY (id)
)

CREATE TABLE Partecipanti(
	idUtente Integer not null,
    idChat Integer not null,
    PRIMARY KEY (idUtente, idChat),
    FOREIGN KEY (idUtente) REFERENCES utenti(id),
    FOREIGN KEY (idChat) REFERENCES Chat(id),
    UNIQUE (idUtente, idChat)
)

CREATE TABLE Messaggi(
	id integer AUTO_INCREMENT,
    idMittente integer not null,
    idChat integer not null,
    testo varchar(500) not null,
  	PRIMARY key (id),
    FOREIGN KEY (idMittente) REFERENCES utenti(id),
    FOREIGN key (idChat) REFERENCES chat(id)
)