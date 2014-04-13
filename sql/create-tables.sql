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

create language plpgsql;
create or replace function hae_viestiketju(viesti_id integer, self boolean)
  returns setof Viesti as
$body$
declare viesti_r viesti%rowtype;

begin
  if self then
    return query select * from viesti where id = viesti_id;
  end if;
  for viesti_r in select * from viesti where liitos_id = viesti_id
    loop
      return next viesti_r;
      return query select * from hae_viestiketju(viesti_r.id, false);
    end loop;
  return;
end
$body$
language 'plpgsql';
