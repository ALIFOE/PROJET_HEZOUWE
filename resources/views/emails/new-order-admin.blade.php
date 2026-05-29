<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle commande</title>
<style>
  body { margin:0; padding:0; background:#f4f4f4; font-family:'Segoe UI',Arial,sans-serif; }
  .wrapper { max-width:620px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#1a3a1a; padding:28px 40px; display:flex; align-items:center; gap:16px; }
  .header h1 { color:#fff; margin:0; font-size:20px; }
  .new-badge { background:#5cb85c; color:#fff; font-size:11px; font-weight:800; padding:3px 10px; border-radius:12px; letter-spacing:.5px; text-transform:uppercase; }
  .body { padding:28px 40px; }
  .alert-new { background:#d4edda; border-left:4px solid #28a745; padding:14px 20px; border-radius:6px; margin-bottom:20px; color:#155724; font-weight:600; }
  .section-title { font-size:0.78rem; font-weight:800; text-transform:uppercase; color:#6c757d; letter-spacing:1px; margin:22px 0 10px; }
  .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px; }
  .info-box { background:#f8f9fa; border-radius:8px; padding:12px 16px; }
  .info-box .label { font-size:0.75rem; color:#6c757d; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
  .info-box .value { font-size:0.95rem; color:#1a3a1a; font-weight:700; margin-top:3px; }
  .payment-box { border:2px solid #ffc107; background:#fff9e6; border-radius:8px; padding:14px 18px; margin:16px 0; }
  .payment-box .p-label { font-size:0.8rem; font-weight:700; color:#856404; text-transform:uppercase; }
  .payment-box .p-method { font-size:1rem; font-weight:800; color:#856404; margin-top:4px; }
  .payment-box .p-txn { font-size:0.85rem; color:#856404; margin-top:4px; }
  .items-table { width:100%; border-collapse:collapse; font-size:14px; margin:10px 0; }
  .items-table th { text-align:left; padding:8px 0; border-bottom:2px solid #dee2e6; color:#6c757d; font-size:11px; text-transform:uppercase; letter-spacing:.5px; }
  .items-table td { padding:10px 0; border-bottom:1px solid #f0f0f0; color:#333; }
  .total-row { background:#f0faf0; border-radius:8px; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; margin:16px 0; }
  .total-row span { color:#6c757d; }
  .total-row strong { font-size:1.2rem; color:#2d6a4f; }
  .btn-admin { display:inline-block; padding:13px 28px; background:#2d6a4f; color:#fff !important; text-decoration:none; border-radius:8px; font-weight:700; font-size:14px; margin:16px 0; }
  .footer { background:#f8f9fa; padding:18px 40px; text-align:center; font-size:12px; color:#adb5bd; }
  @media(max-width:600px){ .header,.body,.footer{padding-left:20px;padding-right:20px;} .info-grid{grid-template-columns:1fr;} }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div>
      <h1>🌾 HEZOUWE — Admin</h1>
    </div>
    <span class="new-badge">Nouvelle commande</span>
  </div>

  <div class="body">
    <div class="alert-new">
      🛒 Une nouvelle commande vient d'être passée et attend votre traitement.
    </div>

    <div class="section-title">Informations client</div>
    <div class="info-grid">
      <div class="info-box">
        <div class="label">Nom</div>
        <div class="value">{{ $order->customer_name }}</div>
      </div>
      <div class="info-box">
        <div class="label">Email</div>
        <div class="value">{{ $order->customer_email }}</div>
      </div>
      <div class="info-box">
        <div class="label">Téléphone</div>
        <div class="value">{{ $order->customer_phone }}</div>
      </div>
      <div class="info-box">
        <div class="label">Ville</div>
        <div class="value">{{ $order->city }}</div>
      </div>
      <div class="info-box" style="grid-column:1/-1">
        <div class="label">Adresse</div>
        <div class="value">{{ $order->address }}</div>
      </div>
    </div>

    <div class="section-title">Paiement</div>
    <div class="payment-box">
      <div class="p-label">Mode de paiement</div>
      <div class="p-method">
        @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
        @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
        @else 🏠 Paiement à la livraison
        @endif
      </div>
      @if($order->transaction_id)
      <div class="p-txn">ID Transaction : <strong>{{ $order->transaction_id }}</strong></div>
      @endif
    </div>

    <div class="section-title">Articles commandés</div>
    @if($order->items && $order->items->count())
    <table class="items-table">
      <thead>
        <tr>
          <th>Produit</th>
          <th style="text-align:center">Qté</th>
          <th style="text-align:right">Prix unit.</th>
          <th style="text-align:right">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product_title }}</td>
          <td style="text-align:center">{{ $item->quantity }}</td>
          <td style="text-align:right">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
          <td style="text-align:right">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    <div class="total-row">
      <span>Total commande</span>
      <strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong>
    </div>

    <div style="text-align:center">
      <a href="{{ url('/admin/orders/' . $order->id) }}" class="btn-admin">
        Voir et traiter la commande →
      </a>
    </div>
  </div>

  <div class="footer">
    Notification automatique — COOP CA HEZOUWE<br>
    <a href="{{ url('/admin/orders') }}">Tableau de bord admin</a>
  </div>

</div>
</body>
</html>
