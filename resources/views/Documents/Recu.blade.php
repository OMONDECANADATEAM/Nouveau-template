<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .receipt-header, .receipt-footer {
            text-align: center;
        }
        .receipt-header h1 {
            margin: 0;
        }
        .receipt-details, .receipt-footer {
            margin-top: 20px;
        }
        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-details table, .receipt-details th, .receipt-details td {
            border: 1px solid #ddd;
        }
        .receipt-details th, .receipt-details td {
            padding: 8px;
            text-align: left;
        }
        .receipt-footer {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Reçu de Paiement</h1>
            <p>Date: {{ date('Y-m-d', strtotime($transaction->date)) }}</p>
        </div>
        <div class="receipt-details">
            <table>
                <tr>
                    <th>Nom:</th>
                    <td>{{ $transaction->candidat->nom }}</td>
                </tr>
                <tr>
                    <th>Prénom:</th>
                    <td>{{ $transaction->candidat->prenom }}</td>
                </tr>
                <tr>
                    <th>Montant:</th>
                    <td>{{ number_format($transaction->montant, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <th>Type de paiement:</th>
                    <td>{{ \App\Models\TypePaiement::where('id', $transaction->id_type_paiement)->value('label') }}</td>
                </tr>
            </table>
        </div>
        <div class="receipt-footer">
            <p>Merci pour votre paiement.</p>
        </div>
    </div>
</body>
</html>
