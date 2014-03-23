create table Käyttäjä(
  id serial primary key, 
  käyttäjänimi varchar(20), 
  käyttäjäryhmä varchar(20), 
  email varchar(64), 
  salasana varchar(256));

create table Aihealue(
  id integer primary key,
  nimi varchar(50),
  kuvaus varchar(200));

create table Viesti(
  id serial primary key, 
  lähettäjä integer references Käyttäjä(id),
  sisältö varchar(10000), 
  otsikko varchar(200), 
  lähetysaika timestamp,
  piilotettu boolean,
  liitos_id integer references Viesti(id), 
  aihealue integer references Aihealue(id));

create table LuettuViesti(
  id serial primary key,
  viesti integer references Viesti(id),
  käyttäjä integer references Käyttäjä(id));


