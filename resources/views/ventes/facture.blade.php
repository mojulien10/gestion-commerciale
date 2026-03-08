<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $vente->numero_vente }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 20px;
        }
        
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 40%;
            text-align: right;
            vertical-align: top;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 10px;
            color: #666;
        }
        
        .facture-title {
            font-size: 28px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 10px;
        }
        
        .facture-numero {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        
        .facture-date {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .info-box {
            display: table-cell;
            width: 48%;
            padding: 15px;
            background: #F3F4F6;
            border-radius: 8px;
        }
        
        .info-box + .info-box {
            margin-left: 4%;
        }
        
        .info-title {
            font-size: 11px;
            font-weight: bold;
            color: #4F46E5;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        
        .info-content {
            font-size: 11px;
        }
        
        .info-content strong {
            font-size: 13px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        thead {
            background: #4F46E5;
            color: white;
        }
        
        thead th {
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        tbody td {
            padding: 10px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 11px;
        }
        
        tbody tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .product-name {
            font-weight: bold;
            color: #333;
        }
        
        .product-code {
            font-size: 10px;
            color: #666;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            padding: 8px 0;
            font-size: 13px;
        }
        
        .total-row.grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #4F46E5;
            border-top: 2px solid #4F46E5;
            padding-top: 15px;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .notes {
            background: #FEF3C7;
            padding: 15px;
            border-left: 4px solid #F59E0B;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .notes-title {
            font-weight: bold;
            color: #92400E;
            margin-bottom: 5px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background: #FEF3C7;
            color: #92400E;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- En-tête -->
        <div class="header">
            <div class="header-left">
                <div class="company-name">💼 GESTION COMMERCIALE</div>
                <div class="company-info">
                    Dakar, Sénégal<br>
                    Tél: +221 XX XXX XX XX<br>
                    Email: contact@gestion-commerciale.sn
                </div>
            </div>
            <div class="header-right">
                <div class="facture-title">FACTURE</div>
                <div class="facture-numero">{{ $vente->numero_vente }}</div>
                <div class="facture-date">
                    Date: {{ $vente->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>
        </div>

        <!-- Informations Client et Vendeur -->
        <div class="info-section">
            <div class="info-box">
                <div class="info-title">👤 Client</div>
                <div class="info-content">
                    <strong>{{ $vente->client->nom }}</strong><br>
                    Tél: {{ $vente->client->telephone }}<br>
                    @if($vente->client->email)
                        Email: {{ $vente->client->email }}<br>
                    @endif
                    @if($vente->client->adresse)
                        Adresse: {{ $vente->client->adresse }}
                    @endif
                </div>
            </div>
            <div class="info-box">
                <div class="info-title">👨‍💼 Vendeur</div>
                <div class="info-content">
                    <strong>{{ $vente->user->name }}</strong><br>
                    Email: {{ $vente->user->email }}
                </div>
            </div>
        </div>

        <!-- Notes (si présentes) -->
        @if($vente->notes)
            <div class="notes">
                <div class="notes-title">📝 Notes:</div>
                {{ $vente->notes }}
            </div>
        @endif

        <!-- Tableau des produits -->
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Produit</th>
                    <th class="text-right" style="width: 15%;">Prix Unit.</th>
                    <th class="text-center" style="width: 10%;">Qté</th>
                    <th class="text-right" style="width: 25%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->lignesVente as $ligne)
                    <tr>
                        <td>
                            <div class="product-name">{{ $ligne->produit->nom }}</div>
                            <div class="product-code">{{ $ligne->produit->code }} - {{ $ligne->produit->categorie->nom }}</div>
                            @if($ligne->is_recommended)
                                <span class="badge">⭐ Recommandé</span>
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} F</td>
                        <td class="text-center">{{ $ligne->quantite }}</td>
                        <td class="text-right"><strong>{{ number_format($ligne->prix_total, 0, ',', ' ') }} F</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total-section">
            <div class="total-row">
                Sous-total: {{ number_format($vente->montant_total, 0, ',', ' ') }} F
            </div>
            <div class="total-row grand-total">
                TOTAL À PAYER: {{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre confiance !</p>
            <p style="margin-top: 10px;">
                Cette facture a été générée électroniquement le {{ now()->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>