# TODO

1. Dobbiamo definire il concetto di Ticket e le azioni collegate al ticket
2. Dobbiamo definire il processo che parte con la richiesta di apertura di un nuovo ticket e si conclude con la risoluzione dello stesso

## Cos'è un ticket?

* Un ticket è un'entità formata da un titolo, un corpo e, opzionalmente, degli allegati.
* Un ticket ha un utente creatore.
* Un ticket ha più assegnatari e solo uno di questi può essere il responsabile (owner).
* Un ticket ha un'area di appartenenza e gli assegnatari posso essere scelti solo tra utenti assegnati alla stessa area.

## Primo step: facciamo un po' di pratica e creiamo un po' di infrastruttura.
Serve un set di endpoint che permettano di:

* Recuperare la lista dei ticket aperti dall'utente
* Recuperare la lista dei ticket di un certo dipartimento
* Recuperare la lista dei ticket assegnati all'utente
