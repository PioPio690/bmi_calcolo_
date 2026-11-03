<?php
// Elaborazione e controllo dati inviati via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $peso = floatval($_POST['peso'] ?? 0);
    $altezza_cm = floatval($_POST['altezza'] ?? 0);

    if ($peso > 0 && $altezza_cm > 0) {
        // Calcolo BMI: peso / (altezza in metri)^2
        $altezza_m = $altezza_cm / 100;
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formattato = number_format($bmi, 2, '.', '');

        // Assegnazione fascia e classe CSS secondo le specifiche
        if ($bmi < 18.5) {
            $fascia = "Sottopeso";
            $classe_card = "sottopeso";
        } elseif ($bmi <= 24.9) {
            $fascia = "Normopeso";
            $classe_card = "normopeso";
        } elseif ($bmi <= 29.9) {
            $fascia = "Sovrappeso";
            $classe_card = "sovrappeso";
        } else {
            $fascia = "Obesità";
            $classe_card = "obesita";
        }
    } else {
        header("Location: form.html");
        exit;
    }
} else {
    header("Location: form.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo BMI</title>
    <style>
        /* Reset di base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #F1F3F5;
            color: #1F2328;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 16px;
        }

        .container {
            width: 100%;
            max-width: 360px;
            text-align: center;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 24px;
            font-weight: 700;
        }

        /* Card del risultato */
        .card {
            border-width: 3px;
            border-style: solid;
            text-align: center;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        .card .user-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1F2328;
            word-break: break-word; /* Evita sforamenti con nomi lunghi su schermi stretti */
        }

        .card .user-details {
            font-size: 14px;
            color: #57606A;
            margin-bottom: 16px;
        }

        .card .bmi-value {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1;
        }

        .card .bmi-category {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Le 4 classi richieste per colore di sfondo, bordo e testo */
        .sottopeso {
            background-color: #E3EEF9;
            border-color: #2F6FB3;
            color: #2F6FB3;
        }

        .normopeso {
            background-color: #E3F4E6;
            border-color: #256D34;
            color: #256D34;
        }

        .sovrappeso {
            background-color: #FCEBD7;
            border-color: #9A4F06;
            color: #9A4F06;
        }

        .obesita {
            background-color: #FBE2E2;
            border-color: #B32D2D;
            color: #B32D2D;
        }

        /* Link per tornare indietro */
        .link-back {
            display: inline-block;
            margin-top: 20px;
            color: #1F2328;
            font-size: 14px;
            text-decoration: underline;
            padding: 8px;
        }

        /* Ottimizzazione per schermi piccoli */
        @media (max-width: 380px) {
            .card {
                padding: 18px;
            }
            .card .bmi-value {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Il tuo BMI</h1>

        <!-- Card dinamica con doppia classe CSS: .card + classe specifica (.sottopeso, .normopeso, ecc.) -->
        <div class="card <?php echo $classe_card; ?>">
            <div class="user-name"><?php echo $nome; ?></div>
            <div class="user-details">Peso <?php echo $peso; ?> kg · Altezza <?php echo $altezza_cm; ?> cm</div>
            <div class="bmi-value"><?php echo $bmi_formattato; ?></div>
            <div class="bmi-category"><?php echo strtoupper($fascia); ?></div>
        </div>

        <a href="form.html" class="link-back">Calcola di nuovo</a>
    </div>

</body>
</html>