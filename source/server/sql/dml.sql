-- insert new user
INSERT INTO utenti (nome, cognome, username, email, password)
VALUES
    ("", "", "", "", "")

-- INSERT INTO utenti (nome, cognome, username, email, password)
-- VALUES
--     ("ratinderdeep", "singh", "ratinderdeep.singh", "robisingh03@gmail.com", "9d7c2f3dd3ace295bba415209b57f74caf59ae026c427354fa2d351387e91b4f"),   -- pass = robi.singh
--     ("michele", "pinotti", "michele.pinotti", "miky03.pinotti@gmail.com", "946cd6caa39234b05e1071a719802a538bdf88ac8ddb7aa656afae6251c69499"),    -- pass = michele.pinotti
--     ("fabio", "barbieri", "fabio.barbieri", "fabiobarbieri294@gmail.com", "a4e01335c4408f75a430df3844696202d7e10c697874eb4024a48e93ac120b4c")   -- pass = fabio.barbieri

-- insert new chat between 2 people
INSERT INTO chat(nome)
VALUES (null)

-- insert new group
INSERT INTO chat(nome)
VALUES ("name")

-- insert partecipants to chat
INSERT INTO partecipanti(idUtente, idChat)
VALUES 
    (, )
    (, )

