--USE mpan;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


ALTER TABLE IF EXISTS `prodotto` DROP FOREIGN KEY `categoria`;
ALTER TABLE IF EXISTS `carrello` DROP FOREIGN KEY `IDprodotto`;

DROP TABLE IF EXISTS carrello;
DROP TABLE IF EXISTS prodotto;
DROP TABLE IF EXISTS marca;
DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS utente;
DROP TABLE IF EXISTS categoria;




CREATE TABLE `categoria` (
  `ID` int(5) UNSIGNED NOT NULL,
  `nome` varchar(11) NOT NULL,
  `immagineSfondo` varchar(100) NOT NULL,
  `keywords` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `categoria` (`ID`, `nome`, `immagineSfondo`, `keywords`) VALUES
(1,'Accessori','images/accessoriLogo.jpg','Olympo Fitness, palestra, negozio palestra, accessori palestra, accessori, pesi liberi , macchinari palestra, macchinari, nutrizione'),
(2,'Pesi Liberi','images/pesiliberiLogo.jpg','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, nutrizione, accessori palestra'),
(3,'Nutrizione','images/nutrizioneLogo.png','Olympo Fitness, palestra, negozio palestra, nutrizione, pesi liberi , macchinari palestra, macchinari, accessori palestra'),
(4,'Macchinari','images/macchinariLogo.jpg','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, macchine, nutrizione, accessori palestra');



CREATE TABLE `utente` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passw` varchar(150) NOT NULL,
  `amministratore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `utente` (`ID`, `nome`, `email`, `passw`, `amministratore`) VALUES
(1, 'user', 'user@user.com', 'user', 0),
(2, 'admin', 'admin@admin.com', 'admin', 1);


CREATE TABLE `faq` (
  `ID` int(10) UNSIGNED NOT NULL,
  `domanda` text NOT NULL,
  `risposta` text DEFAULT NULL,
  `utente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `faq` (`ID`, `domanda`, `risposta`, `utente`) VALUES
(1, 'Quale compagnia si occupa della spedizione?', 'Le spedizioni sono a carico della ditta DHL.', 1),
(2, 'Quali brand collaborano con Olympo Fitness?', 'Puoi consultare l''insieme dei brand tramite la pagine Home, nella sezione: I Nostri Brand.', 1),
(3, 'Avete intenzione di aggiungere nuovi prodotti alimentari in futuro?', 'Si, siamo sempre alla ricerca dei prodotti che soddisfino i nostri clienti.', 1);



CREATE TABLE `marca` (
  `ID` int(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `immagineSfondo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `marca` (`ID`, `nome`, `immagineSfondo`) VALUES
(1, 'Optimum Nutrition', 'images/OptNutLogo.jpg'),
(2, 'Cousin-Trestec', 'images/cousintrestecLogo.png'),
(3, 'Technogym', 'images/TechnogymLogo.jpg'),
(4, 'Bodystrong Fitness', 'images/baodelongLogo.jpg'),
(5, 'Adidas', 'images/adidasLogo.png'),
(6, 'My Protein', 'images/myproteinLogo.png');


CREATE TABLE `prodotto` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `immagine1` varchar(100) DEFAULT NULL,
  `immagine2` varchar(100) DEFAULT NULL,
  `immagine3` varchar(100) DEFAULT NULL,
  `immagine4` varchar(100) DEFAULT NULL,
  `categoria` int(5) UNSIGNED NOT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `prezzo` decimal(5,2) UNSIGNED NOT NULL,
  `peso` varchar(100) NOT NULL,
  `dimensione` varchar(200) NOT NULL,
  `colore` varchar(100) DEFAULT NULL,
  `volume` varchar(100) DEFAULT NULL,
  `materialeUtilizzato` varchar(100) DEFAULT NULL,
  `quantita` int(255) UNSIGNED NOT NULL,
  `descrizione` text NOT NULL,
  `marca` int(20) UNSIGNED NOT NULL,
  `alt` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `prodotto` (`ID`, `nome`, `immagine1`, `immagine2`, `immagine3`, `immagine4`, `categoria`, `keywords`, `prezzo`, `peso`, `dimensione`, `colore`, `volume`, `materialeUtilizzato`, `quantita` , `descrizione`, `marca`,`alt`) VALUES
(1, 'Borsone Adidas', 'images/BorsoneDavanti.jpg', 'images/BorsoneDietro.jpg', 'images/BorsoneAperto.jpg', 'images/BorsoneChiuso.jpg', 1, 'Olympo Fitness, palestra, negozio palestra, borsone, borsone adidas, adidas, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 22 cm x 56 cm x 28 cm', 'Nero', '3900 cl', 'Tela', 10, 'La scelta ideale per la palestra e le gite nel fine settimana. Questo borsone adidas ha una base robusta per proteggere il contenuto. Lo scomparto principale è dotato di una zip bidirezionale per un accesso rapido da entrambi i lati. Le numerose tasche offrono la massima praticità e lo scomparto interno ti consente di tenere separate le scarpe.',5,'Borsone di colore nero, molto capiente'),
(2, 'Borraccia Adidas', 'images/borraccia1.jpg', 'images/borraccia2.jpg', 'images/borraccia3.jpg', 'images/borraccia4.jpg', 1 , 'Olympo Fitness, palestra, negozio palestra, adidas , borraccia adidas , prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 27, '1.0 kg', ' 25 cm x 30 cm x 31 cm', 'Bianco', '100 cl', 'Poliestere riciclato', 15, 'Idratarsi non deve essere complicato. Porta la tua acqua, bevila e poi riempi nuovamente. L’apertura ampia consente di inserire facilmente il ghiaccio. Puoi lavarla in lavastoviglie e riutilizzarla quando vuoi.',5,'Borraccia in plastica di colore bianco da un litro'),
(3, 'Rullo di gomma', 'images/Rullo_3.jpg', 'images/Rullo_2.jpg', 'images/Rullo_1.png', 'images/Rullo_4.jpg',1 , 'Olympo Fitness, palestra, negozio palestra, rullo, adidas , rullo adidas, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 45, '1.5 kg', ' 25 cm x 50 cm x 8 cm', 'Nero', NULL, 'Gomma', 25, 'Allena la mobilità e accelera il recupero. Questo rullo in gomma ti permette di alleviare le tensioni muscolari con un’azione mirata. Le piccole sfere applicano anche un massaggio, favorendo la circolazione del sangue. Compatto e leggero, il rullo è facile da usare e da riporre.',5,'Piccolo rullo di gomma morbida'),
(4, 'Telo Adidas', 'images/telo1.jpg', 'images/telo2.jpg', 'images/telo3.jpg', 'images/telo4.jpg', 1, 'Olympo Fitness, palestra, negozio palestra, telo adidas, asciugamano,  prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 140 cm x 70 cm', 'Nero', NULL, 'Cotone', 25, 'Un asciugamano in cotone che regala la massima comodità. La struttura di ampie dimensioni è realizzata in tessuto leggero ad asciugatura rapida, che assicura grande resistenza.',5,'Telo in cotone molto robusto e leggero'),
(5, 'Manubrio pro', 'images/peso1.jpg', 'images/peso2.jpg', 'images/peso3.jpg', 'images/peso4.jpg', 2, 'Olympo Fitness, palestra, negozio palestra, peso, peso libero, technogym, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 60, '10 kg', ' 30 cm x 10 cm', 'Argento', NULL, 'Acciaio', 25, 'Progettati per la forza e l’allenamento funzionale. La forma esagonale e l’impugnatura zigrinata permettono di ampliare al massimo la varietà di esercizi includendo anche quelli in appoggio a terra.',3,'Manubrio a forma esagonale da 10 chili'),
(6, 'Palla di ghisa', 'images/kettlebells1.jpg', 'images/kettlebells2.jpg', 'images/kettlebells4.jpg', 'images/kettlebells3.jpg', 2, 'Olympo Fitness, palestra, negozio palestra, Kettlebell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 70, '20 kg', '15 cm x 5 cm', NULL, NULL,'Acciaio', 40, 'La palla di ghisa si distingue per la sua forma ergonomica e per la qualità dei materiali costruttivi, inoltre hanno un’impugnatura posizionata in modo univoco per un movimento fluido ed ergonomico. Ideali per allenare forza ed esplosività di tutto il corpo.',3,'Attrezzo ginnico di forma sferica con una maniglia da 20 chili'),
(7, 'Manubrio','images/dumbbell1.jpg','images/dumbbell2.jpg','images/dumbbell3.jpg','images/dumbbell4.jpg',2,'Olympo Fitness, palestra, negozio palestra, dumbbell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 30, '10 kg', '15 cm x 5 cm', NULL, NULL, 'Acciaio', 30, 'I manubri sono studiati per offrirti una sensazione di allenamento naturale e maggiore efficacia, grazie al controllo completo del movimento e al coinvolgimento di più muscoli.',3,'Manubrio in acciaio da 10 chili'),
(8, 'Disco per pesi', 'images/bumper1.jpg', 'images/bumper2.jpg', 'images/bumper3.jpg', 'images/bumper4.jpg',2, 'Olympo Fitness, palestra, negozio palestra, Bumper Plate, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 20, '15 kg', '25 cm x 10 cm x 5 cm', NULL, NULL,'Gomma', 20, 'Realizzati in gomma completamente nera, questi dischi sono progettati per resistere a un uso intensivo e assicurare un ottimo assorbimento degli impatti e un buon rimbalzo. La superficie opaca sui lati esterni dei dischi li rende meno vulnerabili ai graffi.',3,'Dischi per il sollevamento pesi in gomma da 15 chili'),
(9, 'Polvere proteica dal latte', 'images/prot2.jpg', 'images/prot1.jpg', 'images/prot3.jpg', 'images/prot4.jpg',3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 30, '1 kg', '15 cm x 15 cm', NULL, '300 cl',NULL, 50, 'Siero di latte di prima qualità con ben 23 grammi di proteine per porzione, per garantirti le proteine di cui hai bisogno. E da dove viene questo siero di latte? Da mucche allevate al pascolo che producono il latte ed il formaggio che consumi quotidianamente, semplicemente filtrato ed atomizzato al fine di produrre sostanze nutritive completamente naturali.',6,'Polvere proteica estratta dal latte'),
(10, 'Polvere proteica isolata', 'images/isolate1.jpg', 'images/isolate2.jpg', 'images/isolate3.jpg', 'images/isolate4.jpg' ,3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 20, '1 kg', '15 cm x 15 cm', NULL, '200 cl', NULL, 60, 'La polvere proteica isolata non è uno frullato proteico qualunque. A partire da pregiate proteine di siero del latte idrolizzate abbiamo ricavato un’alternativa leggera e rinfrescante, più simile a un succo che a un frullato proteico a base di latte.',6,'Polvere proteica filtrata estratta dal latte'),
(11, 'Dolcetto proteico cioccolato', 'images/brownie1.jpg', 'images/brownie2.jpg', 'images/brownie3.jpg', 'images/brownie4.jpg',3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 10, '500 mg', '30 cm x 15 cm', NULL, NULL, NULL, 60, 'Con fino al 75% di zucchero in meno rispetto alle alternative classiche dei supermercati, goditi uno spuntino pomeridiano senza rovinare tutti i progressi duramente guadagnati.',6,'Barretta proteica rivestita con il cioccolato'),
(12, 'Omega 3 Essenziale', 'images/omega1.jpg', 'images/omega2.jpg', 'images/omega3.jpg', 'images/omega4.jpg' ,3, 'Olympo Fitness, palestra, negozio palestra, vitamine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 10, '500 mg', '30 cm x 15 cm', NULL, '50 cl', NULL, 60, 'Gli omega 3 sono acidi grassi essenziali che il corpo non produce da solo, per cui è necessario ottenerli dall’alimentazione. Si trovano naturalmente nell’olio di pesce, ciò significa che può essere difficile ottenerne una quantità sufficiente soltanto dall’alimentazione.',6,'Vitamine essenziali con omega 3'),
(13, 'Macchinario per petto', 'images/chest1.jpg', 'images/chest2.jpg', 'images/chest3.jpg', 'images/chest4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, chest press, petto, Baodelong ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '85 kg', '130 cm x 95 cm x 103 cm', NULL, NULL,'Acciaio', 60, 'Il macchinario per sviluppare il petto è una concepita per eseguire il gesto multiarticolare di distensione del braccio con sovraccarico, utile soprattutto nel rinforzo del gran pettorale, ma che coinvolge anche il tricipite brachiale e il deltoide.',4,'Macchinario per allenare i pettorali'),
(14, 'Vogatore per cardio', 'images/vogatore1.jpg', 'images/vogatore2.jpg', 'images/vogatore3.jpg', 'images/vogatore4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, vogatore, petto, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 120, '85 kg', '130 cm x 95 cm x 103 cm', NULL, NULL, 'Acciaio', 60, 'Progettato insieme agli atleti, con il vogatore puoi migliorare sia resistenza cardiovascolare che potenza tramite allenamenti completi del corpo sempre vari disponibili sull’applicazione, e con la sensazione di vogata più realistica.',3,'Macchinario per l’allenamento cardiaovascolare'),
(15, 'Macchinario per gambe', 'images/Elliptical1.jpg', 'images/Elliptical2.jpg', 'images/Elliptical3.jpg', 'images/Elliptical4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, Elittica, gambe, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 85, '85 kg', '130 cm x 95 cm x 103 cm', NULL,  NULL,'Acciaio', 60, 'Scopri il potere del tuo corpo con il movimento naturale e confortevole dall’impatto minimo sulle tue articolazioni.',3,'Macchinario per le gambe che evita lesioni alle articolazioni'),
(16, 'Macchinario per bicipiti',  'images/artis1.jpg', 'images/artis2.jpg', 'images/artis3.jpg', 'images/artis4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, Artis Arm Curl, braccia, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 90, '205 kg', '140 cm x 95 cm x 103 cm', NULL,  NULL,'Acciaio', 60, 'Macchinario per bicipiti è specificamente progettato per allenare in modo sicuro ed efficace, ed in comoda posizione seduta, i muscoli delle braccia, specialmente i bicipiti.',3,'Macchinario per allenare i bicipiti');


CREATE TABLE `carrello` (
  `IDutente` int(10) UNSIGNED NOT NULL,
  `IDprodotto` int(10) UNSIGNED NOT NULL,
  `quantita` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `carrello` (`IDutente`, `IDprodotto`, `quantita`) VALUES
(1, 1, 3),
(1, 2, 2),
(1, 3, 2);



ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `utente` (`utente`),
  ADD KEY `amministratore` (`utente`);

ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `marca` (`marca`);

ALTER TABLE `carrello`
  ADD PRIMARY KEY (`IDutente`,`IDprodotto`);







ALTER TABLE `categoria`
  MODIFY `ID` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `utente`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `faq`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `marca`
  MODIFY `ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `prodotto`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;





ALTER TABLE `prodotto`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marca` FOREIGN KEY (`marca`) REFERENCES `marca` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `carrello`
  ADD CONSTRAINT `IDutente` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IDprodotto` FOREIGN KEY (`IDprodotto`) REFERENCES `prodotto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;