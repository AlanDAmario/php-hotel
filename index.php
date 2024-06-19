<?php

$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

//SALVIAMO HOTELS IN UNA NUOVA VARIABILE PER LEGGIBILITà DEL CODICE, RIUTILIZZO ECC
$filtered_hotels = $hotels;

//var_dump($hotels);

//ANDIAMO A SALVARE IN UNA VARIABILE IL CONTENUTO DELL IF COME VALORE BOOLEANO PER GESTIONE ANCHE DEL CHECKED IL GET SERVE COME PUNTO DI CHIAVE PER IL RICHIAMO UNA VOLTA SCELTA L OPZIONE 

//questo codice serve per verificare se il parametro has-parking è stato passato nell'URL e se contiene un valore non vuoto, e di conseguenza imposta la variabile $has_parking a true o false.

$has_parking = !empty($_GET['has-parking']);

//var_dump($has_parking);

//RICERCA HOTEL CON PARCHEGGIO
//ISSET VERIFICA L ESISTENZA DELLA CHIAVE, DENTRO GLI PASSIAMO 'HAS-PARKING' CHE VA A RIPRENDERE LA CHECKBOX
//!EMPTY SERVE A CONTROLLARE SE LA CHIAVE ESISTE ED HA UN VALORE
if ($has_parking) {
    //CREIAMO UN 'CONTATORE' COME LO ERA PER JS IN QUESTA CASO UN ARRAY VUOTO DOVE PUSHARE GLI HOTEL CON PARCHEGGIO
    $with_parking = [];
    //ANDIAMO A CICLARE NUOVAMENTE HOTELS, iterando su hotel
    foreach ($filtered_hotels as $hotel) {
        //SE PARKING è UGUALE A TRUE (=== TRUE)
        //[parking] è LA POSIZIONE DEFINITO NELL ARRAY PER ITERARCI SOPRA
        if ($hotel['parking']) {
            // ALLORA ALL INTERNO DI WITH PARKING ANDIAMO A STAMPARE/PUSHARE (CON UN METODO DI PHP) TUTTI GLI HOTEL CHE DISPONGO DEL PARCHEGGIO
            // NELLA PRIMA POSIZIONE DISPONIBILE '[]', ALLORA INSERIAMO GLI HOTEL DISPONIBILI
            $with_parking[] = $hotel;
            //ALTRO METODO, array_push($with_parking, $hotel)
        }
    }
    //ALLA FINE DEL CICLO POSSIAMO DICHIARARE CHE IL NUOVO FILTERED_HOTELS è WITH_PARKING

    $filtered_hotels = $with_parking;
}


//******************************************************************************************* */
//RICERCA PER STELLE
$has_stars = !empty($_GET['has-stars']); //CARATTERE BOOL
//PUò SUCCEDERE CHE NON ABBIAMO VALORI TIPIZZATI QUINDI DOBBIAMO TRASFORMARLI
//L'operatore di coalescenza nulla ?? in PHP è utilizzato per restituire il valore di una variabile se questa è definita e non è nulla, altrimenti restituisce un valore di default. Questo operatore è molto utile per fornire valori predefiniti per variabili che potrebbero non essere impostate.
$stars = $_GET['has-stars'] ?? 0; //CARATTERE INTERO
if ($has_stars) {
    $with_stars = [];
    foreach ($filtered_hotels as $hotel) {
        // INTVALL() converte una variabile in un numero intero
        if ($hotel['vote'] >= intval($stars)) {
            $with_stars[] = $hotel;
        }
    }
    $filtered_hotels = $with_stars;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container text-center">
        <h1>Hotels</h1>
    </div>
    <!-- RICERCA HOTEL -->
    <div class="container  p-3">
        <form action="index.php" method="GET">
            <div class="row align-items-center">
                <div class="col-auto ">
                    <input class="form-check-input" type="checkbox" value="1" id="has-parking" name="has-parking" <?php if ($has_parking) : ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="has-parking">
                        Con parcheggio?
                    </label>
                </div>
                <div class="col-auto">
                    <select class="form-select" aria-label="Default select example" name="has-stars">
                        <option selected value="">Seleziona stelle</option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option><?php echo $i; ?> <?php echo $i === 1 ? 'star' : 'stars'; ?></option>
                        <?php endfor ?>
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-primary mt-2">Cerca</button>
                </div>
            </div>
        </form>

    </div>
    <hr>

    <div class="container p-3">
        <?php if (empty($filtered_hotels)) : ?>
            <p>Nessun risultato trovato.</p>
        <?php else : ?>
            <table class="table table-striped">
                <thead>

                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Parcheggio</th>
                        <th scope="col">Voto</th>
                        <th scope="col">Distanza dal centro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered_hotels as $hotel) : ?>
                        <tr>
                            <th scope="row"><?php echo $hotel['name'] ?></th>
                            <td><?php echo $hotel['description'] ?></td>
                            <td><?php echo $hotel['parking'] ? 'si' : 'no' ?></td>
                            <td><?php echo $hotel['vote']  ?></td>
                            <td><?php echo $hotel['distance_to_center'] ?> km</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>