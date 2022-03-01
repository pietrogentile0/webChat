# webChat
Web chat similar to WhatsApp Web

Funzioni rimaste da implementare che però non ho fatto in tempo a fare:
- creazione e gestione dei gruppi, comunque la struttura del codice e del database è già predisposta a questa espansione
- aggiornamento automatico delle conversazioni tra tutti i membri (per esempio attualmente se un utente A crea una chat con l'utente B, B non saprà delle nuova creazione fino a quando non aggionerà la pagina e riscaricherà le nuove conversazioni)il sistema sarà simile a quello della chat live (che utilizza un side-car server in Node) e perciò non dovrebbe essere molto difficile implementarlo
- gestione più generale delle notifiche e dell'invio dei messaggi da parte del server side-car (ampliarne l'invio a tutti coloro che hanno la chat, di cui il messaggio fa parte, attiva, ma inviare anche una sorte di notifica a coloro che rientrano in questo caso ma comunque hanno la chat tra le quelle inziate)
