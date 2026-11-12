# Olympo Fitness

E-commerce di attrezzatura e prodotti per il fitness, realizzato come **progetto universitario di gruppo** per il corso di **Tecnologie Web (A.A. 2023/2024)** del Corso di Laurea in Informatica dell'Università degli Studi di Padova.

🔗 **Demo:** https://matthewpan98.github.io/olympo-fitness/

> La demo online è una **versione statica** del sito, generata dal codice PHP e dal database originali. Si possono sfogliare il catalogo, i prodotti e le pagine informative. Login, registrazione e carrello servono solo da esempio, perché richiedono il backend PHP + MySQL (vedi [Eseguire il progetto in locale](#eseguire-il-progetto-in-locale)).

---

## Il progetto

Olympo Fitness è un negozio online di articoli per la palestra. Il catalogo è diviso in quattro categorie:

| Categoria | Esempi |
|---|---|
| **Accessori** | borsoni, borracce, teli, rulli |
| **Pesi liberi** | manubri, kettlebell, dischi, bumper |
| **Nutrizione** | proteine, barrette, integratori |
| **Macchinari** | chest press, ellittica, vogatore |

L'obiettivo era un'interfaccia semplice e chiara, usabile anche da chi non frequenta la palestra, che guidasse l'utente fino all'acquisto. Il sito doveva rispettare gli standard web e i requisiti di **accessibilità** richiesti dal corso.

## Funzionalità

Il sito ha tre aree con permessi diversi, gestiti tramite sessioni PHP.

### Visitatore (area generale)
- Home page con le card delle categorie, i brand e i metodi di pagamento
- Pagine delle quattro categorie, ognuna con il suo elenco di prodotti
- Scheda prodotto con galleria di 4 immagini, specifiche tecniche, descrizione, tempi e costi di consegna
- Pagina **FAQ** divisa per argomento (ordini e spedizioni, alimenti, attrezzatura, resi e rimborsi)
- Pagina **Chi siamo**
- **Login** e **registrazione** con validazione dei dati sia lato client (JavaScript) sia lato server (PHP)
- Pagine di errore personalizzate (404, 500)

### Utente registrato (`areaUtente/`)
- **Carrello** salvato nel database e legato all'account: aggiunta dei prodotti con la quantità scelta, riepilogo con totale e numero di articoli
- Invio di domande dalla pagina FAQ
- Pagina **Area Domande**, con lo storico delle proprie domande e le risposte dell'amministratore
- Logout

### Amministratore (`areaAdmin/`)
- **Gestione prodotti (CRUD):** aggiunta, modifica e rimozione dei prodotti del catalogo
- **Risposta alle domande** inviate dagli utenti
- Accesso in sola consultazione al resto del sito (l'admin non effettua acquisti)

### Accessibilità e responsive design
- HTML semantico, attributi `alt`, `lang` per i termini stranieri, link "salta al contenuto", breadcrumb
- Fogli di stile separati per **desktop**, **tablet**, **mobile** e **stampa**
- Etichette `aria-label` e messaggi di errore e conferma annunciati con `role="alert"`

## Stack tecnologico

| Livello | Tecnologie |
|---|---|
| **Front-end** | HTML5, CSS3 (layout responsive con media query), JavaScript (vanilla) |
| **Back-end** | PHP 8 (procedurale + una classe di accesso ai dati, templating tramite segnaposto nei file HTML) |
| **Database** | MySQL / MariaDB, con accesso tramite estensione `mysqli` |
| **Deploy** | Apache (server universitario), Docker (`php:8.2-apache`), GitHub Pages per la demo statica |
| **Progettazione e collaborazione** | Balsamiq e Figma (wireframe), Git/GitHub, Visual Studio Code |

### Architettura
- **Template HTML + PHP:** ogni pagina `.php` carica un template da `templates/`, prende i dati dal database e sostituisce i segnaposto (es. `{categorie}`, `{brands}`) prima di inviare l'HTML. Struttura e logica restano così separate.
- **Livello di accesso ai dati:** la classe `DB\DBAccess` (`connection.php`) raccoglie connessione e query. Le credenziali arrivano da variabili d'ambiente (`DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`).
- **Database relazionale:** tabelle `categoria`, `marca`, `prodotto`, `utente`, `carrello`, `faq`, collegate da chiavi esterne con `ON DELETE CASCADE`.

## Struttura del repository

```
├── website/               # Sito completo (PHP + MySQL)
│   ├── *.php              # Pagine dell'area generale
│   ├── templates/         # Template HTML dell'area generale
│   ├── areaUtente/        # Pagine e template per l'utente registrato
│   ├── areaAdmin/         # Pagine e template per l'amministratore
│   ├── connection.php     # Classe DBAccess: connessione e query
│   ├── funzioni.php       # Funzioni di supporto (sanitizzazione input, errori)
│   ├── javascript/        # Validazione dei form lato client
│   ├── *.css              # Stili desktop, tablet, mobile, stampa
│   ├── images/            # Immagini di prodotti, categorie e brand
│   ├── database.sql       # Schema e dati di esempio
│   └── relazione/         # Relazione di progetto (PDF/DOCX)
├── docs/                  # Versione statica pubblicata su GitHub Pages
├── scripts/
│   └── build_static.py    # Genera docs/ a partire dal sito PHP
└── Dockerfile             # Immagine PHP + Apache per il sito completo
```

## Eseguire il progetto in locale

Servono **PHP 8** con estensione `mysqli` e **MySQL/MariaDB**.

1. Crea il database e importa i dati di esempio:

```bash
mysql -u root -e "CREATE DATABASE olympo; CREATE USER 'olympo'@'localhost' IDENTIFIED BY 'olympo'; GRANT ALL ON olympo.* TO 'olympo'@'localhost';"
```

```bash
mysql -u root --default-character-set=utf8mb4 olympo < website/database.sql
```

2. Avvia il sito con il server integrato di PHP:

```bash
DB_HOST=localhost DB_USER=olympo DB_PASSWORD=olympo DB_NAME=olympo php -S localhost:8080 -t website
```

3. Apri http://localhost:8080 e accedi con gli account di prova:

| Ruolo | Utente | Password |
|---|---|---|
| Amministratore | `admin` | `admin` |
| Utente | `user` | `user` |

In alternativa si può usare il `Dockerfile` (PHP 8.2 + Apache), passando al container le stesse variabili d'ambiente `DB_*` per il collegamento al database.

### Rigenerare la demo statica

Con il sito PHP avviato su `localhost:8080`:

```bash
python3 scripts/build_static.py http://localhost:8080/
```

Lo script visita le pagine pubbliche e le salva in `docs/` come HTML. Poi converte i link `.php` in `.html` e disattiva i form, che non possono funzionare senza backend.

## Autore

**Matthew Pan**: progetto sviluppato in gruppo per il corso di Tecnologie Web.

La relazione completa del progetto (analisi dei requisiti, progettazione, accessibilità, test) è in [`website/relazione/`](website/relazione/).
