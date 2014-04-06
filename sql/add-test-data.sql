insert into Käyttäjä(id, käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(0, 'admin', 'admin', 'admin@testi.domain', '$2y$10$9uL0l98S2OU2SnSs77A8J.UlX4ZLPnEJhN9P7ynggYzL0D5Xqke22');

insert into Käyttäjä(id, käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(1, 'testaaja', 'käyttäjä', 'testaaja@testi.domain', '$2y$10$9uL0l98S2OU2SnSs77A8J.UlX4ZLPnEJhN9P7ynggYzL0D5Xqke22');

insert into Aihealue(id, nimi, kuvaus) VALUES(10, 'Offtopic', 'Random höpinää');

insert into Viesti(id, sisältö, otsikko, lähetysaika, piilotettu, liitos_id, aihealue) VALUES(0, 'Testiviestin sisältö', 'Testiviesti', current_timestamp, false, null, 10);

insert into LuettuViesti(viesti, käyttäjä) VALUES(0, 0);
