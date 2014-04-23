insert into Käyttäjä(id, käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(0, 'admin', 'admin', 'admin@testi.domain', '$2a$08$3wUOhx/sSZaDltKhPEm5NeTL4vJVmfm5On.x7qOyeaqCWDuZCNzbu');

insert into Käyttäjä(id, käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(1, 'testaaja', 'käyttäjä', 'testaaja@testi.domain', '$2a$08$3wUOhx/sSZaDltKhPEm5NeTL4vJVmfm5On.x7qOyeaqCWDuZCNzbu');

insert into Aihealue(id, nimi, kuvaus) VALUES(10, 'Offtopic', 'Random höpinää');

insert into Viesti(id, sisältö, otsikko, lähetysaika, piilotettu, liitos_id, aihealue, lähettäjä) VALUES(0, 'Testiviestin sisältö', 'Testiviesti', current_timestamp, false, null, 10, 1);

insert into Viesti(id, sisältö, lähetysaika, piilotettu, liitos_id, aihealue, lähettäjä) VALUES(1, 'Lorem ipsum vastaus tms', current_timestamp, false, 0, 10, 0);

insert into Viesti(id, sisältö, lähetysaika, piilotettu, liitos_id, aihealue, lähettäjä) VALUES(2, 'Lorem ipsumiin toinen vastaus', current_timestamp, false, 0, 10, 1);

insert into Viesti(id, sisältö, otsikko, lähetysaika, piilotettu, liitos_id, aihealue, lähettäjä) VALUES(3, 'Toisen topicin sisältö', 'toinen topic', current_timestamp, false, null, 10, 0);
insert into LuettuViesti(viesti, käyttäjä) VALUES(0, 0);

-- ID laskurien korjaus.
-- Jostain syystä ne omalla koneella testatessa oli aina pielessä
select setval('viesti_id_seq', (select max(id) from viesti)+1);
select setval('käyttäjä_id_seq', (select max(id) from käyttäjä)+1);
