-- get all conversations of user (non con il nome dell'utente se non è un gruppo)
SELECT c.*
FROM partecipanti AS p, chat as c
WHERE p.idChat = c.id AND p.idUtente = 1

-- per ottenere tutte le chat di un utente (sia gruppo sia utente)
SELECT c.id, COALESCE(c.nome, u.nome) AS nome
FROM utenti AS u,
	partecipanti AS p,
    (SELECT c.* FROM partecipanti AS p, chat as c WHERE p.idChat = c.id AND p.idUtente = 1) AS c	-- trova tutte le chat di un utente
WHERE u.id = p.idUtente
	AND p.idChat = c.id
    AND u.id <> 1
GROUP BY c.id
