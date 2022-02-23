-- per ottenere tutte le chat di un utente (sia gruppo sia utente)
-- se una chat ha un nome è un gruppo e viene restituito il suo nome
-- altrimenti è una chat semplice (2 utenti) e viene restituito il nome dell'altro utente e il suo username (null nel caso sia un gruppo)
SELECT c.id, COALESCE(c.nome, u.nome) AS nome, IF(ISNULL(c.nome), u.username, c.nome) AS username
FROM utenti AS u,
    partecipanti AS p,
    (SELECT c.* FROM partecipanti AS p, chat as c WHERE p.idChat = c.id AND p.idUtente = $userId) AS c
WHERE u.id = p.idUtente
    AND p.idChat = c.id
    AND u.id <> $userId
GROUP BY c.id

-- ottenere tutti i messaggi di una conversazione (con il nome del mittente nel caso fosse un gruppo)
SELECT m.id, m.testo, IF(ISNULL(c.nome), null, username) AS username_mittente
FROM messaggi AS m, utenti AS u, chat AS c
WHERE u.id = m.idMittente
    AND m.idChat = c.id
    AND idChat = $chatId