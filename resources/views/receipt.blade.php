<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reçu {{ $order->order_number }} — HEZOUWE</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #eef2ed;
    color: #17351a;
    font-size: 13px;
    padding: 30px 16px;
}

/* ── Toolbar ── */
.toolbar {
    max-width: 740px;
    margin: 0 auto 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.toolbar-title { font-weight: 900; color: #1a3a1a; font-size: 15px; }
.btn-back, .btn-print {
    display: inline-block;
    padding: 9px 18px;
    border-radius: 7px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    border: none;
    margin-left: 8px;
}
.btn-back { background: #fff; color: #1a3a1a; border: 1.5px solid #c8d8c0; }
.btn-print { background: #2d6a4f; color: #fff; }
.btn-print:hover { background: #1a3a1a; }

/* ── Receipt wrapper ── */
.receipt {
    max-width: 740px;
    margin: 0 auto;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 28px rgba(23,53,26,.13);
}

/* ── Print ── */
@media print {
    body { background: #fff; padding: 0; }
    .toolbar { display: none; }
    .receipt { box-shadow: none; border-radius: 0; max-width: 100%; }
    @page { margin: 0.5cm; size: A4; }
}
</style>
</head>
<body>

<!-- Toolbar -->
<div class="toolbar">
    <div class="toolbar-title">Reçu de paiement — {{ $order->order_number }}</div>
    <div>
        <a href="/dashboard" class="btn-back">← Mon espace client</a>
        <button class="btn-print" onclick="downloadPDF()">🖨 Imprimer / Télécharger PDF</button>
    </div>
</div>

<!-- Receipt -->
<div class="receipt" id="receipt-content">

    <!-- ── HEADER ── -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#1a3a1a;">
        <tr>
            <td style="padding:26px 32px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <!-- Brand -->
                        <td style="width:55%; vertical-align:middle;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-right:14px; vertical-align:middle;">
                                        <img src="{{ asset('assets/img/logo/logo_hezouwe.jpeg') }}"
                                             alt="Logo"
                                             width="60" height="60"
                                             style="border-radius:8px; background:#fff; padding:2px; display:block;">
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div style="color:#d5a741; font-size:9px; font-weight:900; letter-spacing:2px; text-transform:uppercase; margin-bottom:4px;">Coopérative du Riz Local</div>
                                        <div style="color:#ffffff; font-size:18px; font-weight:900; margin-bottom:3px;">COOP CA HEZOUWE</div>
                                        <div style="color:rgba(255,255,255,0.55); font-size:11px;">Tagbega, Wahala — Région Plateaux, TOGO</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!-- Receipt info -->
                        <td style="width:45%; vertical-align:middle; text-align:right;">
                            <div style="display:inline-block; background:#5cb85c; color:#fff; font-size:9px; font-weight:900; text-transform:uppercase; padding:4px 14px; border-radius:999px; letter-spacing:1px; margin-bottom:10px;">✓ Reçu de paiement</div>
                            <div style="color:#ffffff; font-size:20px; font-weight:900; font-family:monospace; margin-bottom:5px;">{{ $order->order_number }}</div>
                            <div style="color:rgba(255,255,255,0.55); font-size:11px;">Émis le {{ $order->updated_at->format('d/m/Y à H:i') }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── STATUS BAR ── -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#e8f5e9; border-bottom:1px solid #c3ddc0;">
        <tr>
            <td style="padding:12px 32px;">
                <span style="font-size:18px; margin-right:10px;">✅</span>
                <span style="color:#155724; font-weight:700; font-size:13px;">Paiement validé et confirmé par COOP CA HEZOUWE</span>
            </td>
        </tr>
    </table>

    <!-- ── CLIENT + LIVRAISON ── -->
    <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #e8eee3;">
        <tr>
            <!-- Client -->
            <td width="50%" style="padding:22px 28px; vertical-align:top; border-right:1px solid #e8eee3;">
                <div style="font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#68746a; border-bottom:1px solid #e8eee3; padding-bottom:8px; margin-bottom:14px;">Informations client</div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Nom</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Email</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->customer_email }}</td>
                    </tr>
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Téléphone</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->customer_phone }}</td>
                    </tr>
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Date commande</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </td>
            <!-- Livraison -->
            <td width="50%" style="padding:22px 28px; vertical-align:top;">
                <div style="font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#68746a; border-bottom:1px solid #e8eee3; padding-bottom:8px; margin-bottom:14px;">Livraison</div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Ville</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->city }}</td>
                    </tr>
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Adresse</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->address }}</td>
                    </tr>
                    @if($order->notes)
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Notes</td>
                        <td style="font-weight:700; color:#17351a; text-align:right; padding:5px 0; font-size:12px;">{{ $order->notes }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="color:#68746a; padding:5px 0; font-size:12px;">Statut</td>
                        <td style="font-weight:700; color:#24782b; text-align:right; padding:5px 0; font-size:12px;">
                            @php $statusLabels = ['pending'=>'En attente','confirmed'=>'Confirmée','preparing'=>'En préparation','shipped'=>'En livraison','delivered'=>'Livrée','cancelled'=>'Annulée']; @endphp
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── MODE DE PAIEMENT ── -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:16px 28px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0faf0; border:1px solid #c3ddc0; border-radius:8px;">
                    <tr>
                        <td style="padding:14px 20px;">
                            <div style="color:#68746a; font-size:11px; margin-bottom:4px;">Mode de paiement</div>
                            <div style="font-weight:900; color:#17351a; font-size:13px;">
                                @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
                                @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
                                @else 🏠 Paiement à la livraison
                                @endif
                            </div>
                        </td>
                        <td style="text-align:right; padding:14px 20px;">
                            <span style="background:#e7f7e7; color:#24782b; font-size:11px; font-weight:900; padding:5px 14px; border-radius:999px;">✓ Payé</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── ARTICLES ── -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:0 28px 20px;">
                <div style="font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#68746a; border-bottom:2px solid #e8eee3; padding-bottom:8px; margin-bottom:4px;">Articles commandés</div>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding:10px 0; color:#68746a; font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:.5px; border-bottom:1px solid #e8eee3; width:40%;">Désignation</th>
                            <th style="text-align:center; padding:10px 0; color:#68746a; font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:.5px; border-bottom:1px solid #e8eee3; width:10%;">Qté</th>
                            <th style="text-align:right; padding:10px 0; color:#68746a; font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:.5px; border-bottom:1px solid #e8eee3; width:25%;">Prix unitaire</th>
                            <th style="text-align:right; padding:10px 0; color:#68746a; font-size:9px; font-weight:900; text-transform:uppercase; letter-spacing:.5px; border-bottom:1px solid #e8eee3; width:25%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td style="padding:11px 0; border-bottom:1px solid #f0f4f0; color:#17351a;">
                                <div style="font-weight:700;">{{ $item->product_title }}</div>
                                <div style="color:#9aaa95; font-size:10px; margin-top:2px;">Réf. {{ $item->product_slug }}</div>
                            </td>
                            <td style="text-align:center; padding:11px 0; border-bottom:1px solid #f0f4f0; color:#17351a;">{{ $item->quantity }}</td>
                            <td style="text-align:right; padding:11px 0; border-bottom:1px solid #f0f4f0; color:#17351a;">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                            <td style="text-align:right; padding:11px 0; border-bottom:1px solid #f0f4f0; color:#17351a; font-weight:700;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── TOTAUX ── -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:0 28px 24px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-top:2px solid #e8eee3;">
                    <tr>
                        <td style="padding:7px 0; color:#68746a; font-size:13px;">Sous-total</td>
                        <td style="padding:7px 0; text-align:right; font-weight:700; color:#17351a; font-size:13px;">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <td style="padding:7px 0; color:#68746a; font-size:13px;">Frais de livraison</td>
                        <td style="padding:7px 0; text-align:right; font-weight:700; font-size:13px; color:{{ $order->delivery_cost == 0 ? '#24782b' : '#17351a' }};">
                            {{ $order->delivery_cost == 0 ? 'Gratuite' : number_format($order->delivery_cost, 0, ',', ' ').' FCFA' }}
                        </td>
                    </tr>
                    @if($order->discount > 0)
                    <tr>
                        <td style="padding:7px 0; color:#68746a; font-size:13px;">Remise</td>
                        <td style="padding:7px 0; text-align:right; font-weight:700; color:#24782b; font-size:13px;">- {{ number_format($order->discount, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2"><div style="border-top:2px solid #e8eee3; margin:8px 0;"></div></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 0; color:#1a3a1a; font-weight:900; font-size:15px;">TOTAL PAYÉ</td>
                        <td style="padding:6px 0; text-align:right; font-weight:900; color:#2d6a4f; font-size:20px;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── TAMPON ── -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:0 28px 24px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faf7; border:1px solid #e8eee3; border-radius:8px;">
                    <tr>
                        <td style="padding:14px 20px; vertical-align:top;">
                            <div style="color:#68746a; font-size:10px; margin-bottom:3px;">Document émis par</div>
                            <div style="font-weight:800; color:#1a3a1a; font-size:13px;">COOP CA HEZOUWE — Tagbega, Wahala, TOGO</div>
                            <div style="color:#68746a; font-size:10px; margin-top:3px;">Email : contact@hezouwe.com &nbsp;|&nbsp; Tél : +228 70 67 94 48</div>
                        </td>
                        <td style="padding:14px 20px; text-align:right; vertical-align:top;">
                            <div style="color:#9aaa95; font-size:10px;">Reçu généré le {{ now()->format('d/m/Y à H:i') }}</div>
                            <div style="color:#9aaa95; font-size:10px; margin-top:3px;">N° commande : <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── FOOTER ── -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#0f2810;">
        <tr>
            <td style="padding:18px 32px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="color:rgba(255,255,255,0.4); font-size:11px;">Ce document constitue un reçu officiel de paiement émis par COOP CA HEZOUWE.</td>
                        <td style="text-align:right; color:rgba(255,255,255,0.4); font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE — Tous droits réservés</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>

<script>
function downloadPDF() {
    const btn = document.querySelector('.btn-print');
    btn.disabled = true;
    btn.textContent = '⏳ Génération en cours…';

    const element = document.getElementById('receipt-content');

    const opt = {
        margin:      [6, 6, 6, 6],
        filename:    'recu-{{ $order->order_number }}.pdf',
        image:       { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, logging: false, allowTaint: true },
        jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        btn.disabled    = false;
        btn.textContent = '🖨 Imprimer / Télécharger PDF';
    });
}
</script>

</body>
</html>
