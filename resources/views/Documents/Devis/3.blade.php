<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devis pour Travailleur Temporaire</title>
    <style>
        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Lato-Regular.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Lato';
            font-style: italic;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Lato-Italic.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            src: url('{{ storage_path('fonts/Lato-Bold.ttf') }}') format('truetype');
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Lato', sans-serif;
            margin: 0 40px;
            font-size: 12px;
        }
        .container {
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .title {
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .highlight {
            color: red;
        }
    </style>
</head>
<body>
      
    <br/><br/><br/><br/><br/><br/><br/><br/>  <br/><br/><br/><br/><br/><br/><br/><br/>
   <div class="container">
        <div class="title">DEVIS POUR TRAVAILLEUR TEMPORAIRE</div>
        <table class="table">
            <tr>
                <th>DESCRIPTION</th>
                <th>COÛT</th>
                <th>RESULTAT ATTENDU</th>
            </tr>
            <tr>
                <td>Conseils, Orientation, choix du test de français et Guide de préparation au test de français</td>
                <td rowspan="4" class="highlight">4 550 000 FCFA</td>
                <td>Étude d’impact sur le marché du travail - accepté par le Québec, Contrat de travail signé par les deux parties (employeur et employé)</td>
            </tr>
            <tr>
                <td>Recherche de contrat de travail fermé au Canada</td>
                <td></td>
            </tr>
            <tr>
                <td>EIMT (Étude d’impact sur le marché du travail), Suggestion de formations pour mise à niveau le cas échéant</td>
                <td></td>
            </tr>
            <tr>
                <td>Préparation des documents pour la demande de permis de travail, demande d’examens médicaux, biométrie et demande de visa</td>
                <td>Transmission de la demande du permis de travail au Canada, Décision de l’immigration canadienne</td>
            </tr>
        </table>
    </div>
</body>
</html>
