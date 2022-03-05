# ChaLiWhat, Chat Like Whatsapp

## Da quali parti è composto il progetto?

> Parte client

1. pagina di login, permette di effettuare il login o passare a pagina di signup
    - *Tecnologie utilizzate:*
        - JWT impostato come cookie che, contenendo informazioni riguardo l'utente, è utile anche per semplificare e snellire le comunicazioni tra client e server

2. pagina di singup, permette di effettuare la creazione di un nuovo utente

3. pagina principale (home):
    - *Funzionalità*
        - ricercare utente tramite username, per **inziare una conversazione**
        - **selezionare un utente** tra le conversazioni iniziate per inviare messaggi
        - **inviare messaggi** e riceverli in diretta, senza dover riaggionare la pagina
    - *Tecnologie utilizzate:*
        - HTML, CSS e Bootstrap per la visualizzazione della pagina
        - Javascript per la comunicazione con il server per:
            - comunicare con il server backbone per inviare o richiedere risorse, tramite Fetch API
            - comunicare con il server side-car per ricevere i nuvoi messaggi in tempo reale, tramite WebSocket
            - aggiungere gli elementi necessari per rendere dinamica la pagine, per mostrare conversazioni e messaggi


> Parte server di backbone (implementata in PHP), si occupa di:
- gestire l'**autenticazione** degli utenti, fornendo JWT, e **verificandone** l'effettiva **validità**
- gestire la creazione di **nuovi utenti**
- inserire le **nuove conversazioni** nel database in base alle richieste degli utenti
- inserire i **nuovi messaggi** nel database e **comunicare al server side-car** che ne gestisce l'invio, trmite WebSocket, ai client destinatari
- **inviare** al client, all'apertura dela pagina home, tutte le **conversazioni inziate**
- **inviare** al client, dopo che quest'ultimo abbia scelto una conversazione, tutti i **messaggi** che vi appartengono

Parte server per gestione della chat live (implementata in javascript)


### Come far funzionare la pagina:
- caricare i file sorgente su un server che risponde al dominio localhost sulla porta 80
- creare su di un database MySQL le tabelle in base al codice presente in source/server/sql/ddl.sql
- eseguire il file notifier.js con Nodejs
- ricercare sul browser http://localhost/chaliwhat/source/client/home/home.php

Funzioni rimaste da implementare che però non ho fatto in tempo a fare:
- creazione e gestione dei gruppi, comunque la struttura del codice e del database è già predisposta a questa espansione
- aggiornamento automatico delle conversazioni tra tutti i membri (per esempio attualmente se un utente A crea una chat con l'utente B, B non saprà delle nuova creazione fino a quando non aggionerà la pagina e riscaricherà le nuove conversazioni)il sistema sarà simile a quello della chat live (che utilizza un side-car server in Node) e perciò non dovrebbe essere molto difficile implementarlo
- gestione più generale delle notifiche e dell'invio dei messaggi da parte del server side-car (ampliarne l'invio a tutti coloro che hanno la chat, di cui il messaggio fa parte, attiva, ma inviare anche una sorte di notifica a coloro che rientrano in questo caso ma comunque hanno la chat tra le quelle inziate)
