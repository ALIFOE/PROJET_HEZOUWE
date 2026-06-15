<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reçu {{ $order->order_number }} — HEZOUWE</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
/* ── Base ─────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f0f4ef;
    color: #17351a;
    font-size: 14px;
    line-height: 1.5;
    padding: 40px 20px;
}

/* ── No-print toolbar ──────────────────────────────── */
.toolbar {
    max-width: 780px;
    margin: 0 auto 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.toolbar-title { font-weight: 900; color: #1a3a1a; font-size: 1rem; }
.toolbar-actions { display: flex; gap: 10px; }
.btn-print, .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 800;
    font-size: 0.88rem;
    cursor: pointer;
    text-decoration: none;
    border: none;
}
.btn-print {
    background: #2d6a4f;
    color: #fff;
}
.btn-print:hover { background: #1a3a1a; }
.btn-back {
    background: #fff;
    color: #1a3a1a;
    border: 1.5px solid #dfe8db;
}
.btn-back:hover { background: #f5f5f5; }

/* ── Receipt card ─────────────────────────────────── */
.receipt {
    max-width: 780px;
    margin: 0 auto;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 32px rgba(23,53,26,.12);
}

/* ── Header ───────────────────────────────────────── */
.receipt-header {
    background: #1a3a1a;
    padding: 28px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
}
.header-brand {
    display: flex;
    align-items: center;
    gap: 16px;
}
.header-brand img {
    height: 64px;
    width: auto;
    border-radius: 8px;
    background: #fff;
    padding: 2px;
}
.brand-text p {
    margin: 0 0 2px;
    color: #d5a741;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.brand-text h1 {
    margin: 0;
    color: #fff;
    font-size: 20px;
    font-weight: 900;
}
.brand-text small {
    color: rgba(255,255,255,.6);
    font-size: 11px;
}

.header-receipt-info { text-align: right; }
.receipt-badge {
    display: inline-block;
    background: #5cb85c;
    color: #fff;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 999px;
    letter-spacing: .5px;
    margin-bottom: 10px;
}
.receipt-number {
    font-size: 1.4rem;
    font-weight: 900;
    color: #fff;
    font-family: monospace;
    display: block;
}
.receipt-date {
    color: rgba(255,255,255,.65);
    font-size: 12px;
    display: block;
    margin-top: 4px;
}

/* ── Status bar ───────────────────────────────────── */
.status-bar {
    background: #e8f5e9;
    border-bottom: 1px solid #c3ddc0;
    padding: 14px 40px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.status-icon { font-size: 22px; }
.status-text { color: #155724; font-weight: 700; font-size: 14px; }

/* ── Two-column layout ───────────────────────────── */
.info-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border-bottom: 1px solid #e8eee3;
}
.info-block {
    padding: 24px 28px;
    border-right: 1px solid #e8eee3;
}
.info-block:last-child { border-right: none; }
.info-block h3 {
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #68746a;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e8eee3;
}
.info-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 5px 0;
    font-size: 13px;
}
.info-row .label { color: #68746a; }
.info-row .value { font-weight: 700; color: #17351a; text-align: right; }
.info-row .value.mono { font-family: monospace; }
.info-row .value.green { color: #24782b; }
.info-row .value.red { color: #b42323; }

/* ── Payment highlight ───────────────────────────── */
.payment-highlight {
    margin: 0 28px 20px;
    padding: 14px 20px;
    background: #f0faf0;
    border: 1px solid #c3ddc0;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}
.payment-highlight .pm-label { color: #68746a; font-size: 12px; }
.payment-highlight .pm-value { font-weight: 900; color: #17351a; font-size: 14px; margin-top: 2px; }
.payment-highlight .pm-badge {
    display: inline-block;
    background: #e7f7e7;
    color: #24782b;
    font-size: 11px;
    font-weight: 900;
    padding: 4px 12px;
    border-radius: 999px;
}

/* ── Items table ─────────────────────────────────── */
.items-section { padding: 0 28px 20px; }
.items-section h3 {
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #68746a;
    margin-bottom: 14px;
    padding: 20px 0 8px;
    border-bottom: 2px solid #e8eee3;
}
.items-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.items-table th {
    padding: 10px 0;
    text-align: left;
    color: #68746a;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .5px;
    border-bottom: 1px solid #e8eee3;
}
.items-table th.right { text-align: right; }
.items-table th.center { text-align: center; }
.items-table td {
    padding: 12px 0;
    border-bottom: 1px solid #f0f4f0;
    color: #17351a;
}
.items-table td.right { text-align: right; }
.items-table td.center { text-align: center; }
.items-table tr:last-child td { border-bottom: none; }
.product-name { font-weight: 700; color: #17351a; }
.product-slug { display: block; color: #9aaa95; font-size: 11px; margin-top: 2px; }

/* ── Totals ──────────────────────────────────────── */
.totals-section {
    margin: 0 28px;
    border-top: 2px solid #e8eee3;
    padding: 16px 0 24px;
}
.total-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 5px 0;
    font-size: 13px;
}
.total-row .tl { color: #68746a; }
.total-row .tr { font-weight: 700; color: #17351a; }
.total-row.grand {
    margin-top: 10px;
    padding-top: 14px;
    border-top: 2px solid #e8eee3;
    font-size: 16px;
}
.total-row.grand .tl { color: #1a3a1a; font-weight: 900; font-size: 15px; }
.total-row.grand .tr { color: #2d6a4f; font-weight: 900; font-size: 20px; }

/* ── QR / Auth band ──────────────────────────────── */
.auth-band {
    margin: 0 28px 28px;
    padding: 14px 20px;
    background: #f8faf7;
    border: 1px solid #e8eee3;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.auth-band .auth-label { font-size: 11px; color: #68746a; }
.auth-band .auth-value { font-weight: 800; color: #1a3a1a; font-size: 13px; }
.auth-stamp {
    font-size: 11px;
    color: #9aaa95;
    text-align: right;
}

/* ── Footer ──────────────────────────────────────── */
.receipt-footer {
    background: #0f2810;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}
.receipt-footer p { margin: 0; color: rgba(255,255,255,.45); font-size: 11px; }
.receipt-footer a { color: #d5a741; text-decoration: none; }

/* ── Print styles ────────────────────────────────── */
@media print {
    body { background: #fff; padding: 0; }
    .toolbar { display: none; }
    .receipt { box-shadow: none; border-radius: 0; max-width: 100%; }
    .receipt-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .status-bar, .payment-highlight, .auth-band { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .receipt-footer { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    @page { margin: 0.5cm; size: A4; }
}
</style>
</head>
<body>

<!-- Toolbar (hidden on print) -->
<div class="toolbar">
    <div class="toolbar-title">Reçu de paiement — {{ $order->order_number }}</div>
    <div class="toolbar-actions">
        <a href="/dashboard" class="btn-back">← Mon espace client</a>
        <button class="btn-print" onclick="downloadPDF()">🖨 Imprimer / Télécharger PDF</button>
    </div>
</div>

<!-- Receipt -->
<div class="receipt">

    <!-- Header -->
    <div class="receipt-header">
        <div class="header-brand">
            <img src="{{ asset('assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE Logo">
            <div class="brand-text">
                <p>Coopérative du Riz Local</p>
                <h1>COOP CA HEZOUWE</h1>
                <small>Tagbega, Wahala — Région Plateaux, TOGO</small>
            </div>
        </div>
        <div class="header-receipt-info">
            <div class="receipt-badge">✓ Reçu de paiement</div>
            <span class="receipt-number">{{ $order->order_number }}</span>
            <span class="receipt-date">Émis le {{ $order->updated_at->format('d/m/Y à H:i') }}</span>
        </div>
    </div>

    <!-- Status bar -->
    <div class="status-bar">
        <span class="status-icon">✅</span>
        <span class="status-text">Paiement validé et confirmé par COOP CA HEZOUWE</span>
    </div>

    <!-- Client + Delivery info -->
    <div class="info-section">
        <div class="info-block">
            <h3>Informations client</h3>
            <div class="info-row">
                <span class="label">Nom</span>
                <span class="value">{{ $order->customer_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email</span>
                <span class="value">{{ $order->customer_email }}</span>
            </div>
            <div class="info-row">
                <span class="label">Téléphone</span>
                <span class="value">{{ $order->customer_phone }}</span>
            </div>
            <div class="info-row">
                <span class="label">Date commande</span>
                <span class="value">{{ $order->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="info-block">
            <h3>Livraison</h3>
            <div class="info-row">
                <span class="label">Ville</span>
                <span class="value">{{ $order->city }}</span>
            </div>
            <div class="info-row">
                <span class="label">Adresse</span>
                <span class="value">{{ $order->address }}</span>
            </div>
            @if($order->notes)
            <div class="info-row">
                <span class="label">Notes</span>
                <span class="value">{{ $order->notes }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="label">Statut commande</span>
                <span class="value green">
                    @php $statusLabels = ['pending'=>'En attente','confirmed'=>'Confirmée','preparing'=>'En préparation','shipped'=>'En livraison','delivered'=>'Livrée','cancelled'=>'Annulée']; @endphp
                    {{ $statusLabels[$order->status] ?? $order->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Payment info highlight -->
    <div class="payment-highlight">
        <div>
            <div class="pm-label">Mode de paiement</div>
            <div class="pm-value">
                @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
                @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
                @else 🏠 Paiement à la livraison
                @endif
            </div>
        </div>
        <div class="pm-badge">✓ Payé</div>
    </div>

    <!-- Items -->
    <div class="items-section">
        <h3>Articles commandés</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:40%;">Désignation</th>
                    <th class="center" style="width:10%;">Qté</th>
                    <th class="right" style="width:25%;">Prix unitaire</th>
                    <th class="right" style="width:25%;">Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <span class="product-name">{{ $item->product_title }}</span>
                        <span class="product-slug">Réf. {{ $item->product_slug }}</span>
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                    <td class="right" style="font-weight:700;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="totals-section">
        <div class="total-row">
            <span class="tl">Sous-total</span>
            <span class="tr">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="total-row">
            <span class="tl">Frais de livraison</span>
            <span class="tr" style="{{ $order->delivery_cost == 0 ? 'color:#24782b' : '' }}">
                {{ $order->delivery_cost == 0 ? 'Gratuite' : number_format($order->delivery_cost, 0, ',', ' ').' FCFA' }}
            </span>
        </div>
        @if($order->discount > 0)
        <div class="total-row">
            <span class="tl">Remise</span>
            <span class="tr" style="color:#24782b;">- {{ number_format($order->discount, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        <div class="total-row grand">
            <span class="tl">TOTAL PAYÉ</span>
            <span class="tr">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <!-- Auth stamp -->
    <div class="auth-band">
        <div>
            <div class="auth-label">Document émis par</div>
            <div class="auth-value">COOP CA HEZOUWE — Tagbega, Wahala, TOGO</div>
            <div class="auth-label" style="margin-top:4px;">Email : contact@hezouwe.tg &nbsp;|&nbsp; Tél : +228 70 67 94 48</div>
        </div>
        <div class="auth-stamp">
            Reçu généré le {{ now()->format('d/m/Y à H:i') }}<br>
            Numéro de commande : <strong>{{ $order->order_number }}</strong>
        </div>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
        <p>Ce document constitue un reçu officiel de paiement émis par COOP CA HEZOUWE.</p>
        <p>&copy; {{ date('Y') }} COOP CA HEZOUWE — Tous droits réservés</p>
    </div>

</div>

<script>
function downloadPDF() {
    const btn = document.querySelector('.btn-print');
    btn.disabled = true;
    btn.textContent = '⏳ Génération en cours…';

    const element = document.querySelector('.receipt');

    // Forcer temporairement la largeur pour centrer le contenu dans le PDF
    const prev = { maxWidth: element.style.maxWidth, margin: element.style.margin };
    element.style.maxWidth = '100%';
    element.style.margin   = '0';

    const opt = {
        margin:     [8, 8, 8, 8],
        filename:   'recu-{{ $order->order_number }}.pdf',
        image:      { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, logging: false, windowWidth: 800 },
        jsPDF:      { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        element.style.maxWidth = prev.maxWidth;
        element.style.margin   = prev.margin;
        btn.disabled  = false;
        btn.textContent = '🖨 Imprimer / Télécharger PDF';
    });
}
</script>
</body>
</html>
