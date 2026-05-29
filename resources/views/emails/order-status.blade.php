<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mise à jour de votre commande</title>
<style>
  body { margin:0; padding:0; background:#f4f4f4; font-family:'Segoe UI',Arial,sans-serif; }
  .wrapper { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#2d6a4f; padding:32px 40px; text-align:center; }
  .header img { height:50px; }
  .header h1 { color:#fff; margin:12px 0 0; font-size:22px; letter-spacing:.5px; }
  .status-banner { padding:24px 40px; text-align:center; }
  .status-icon { font-size:48px; }
  .status-label { display:inline-block; margin:12px 0 0; padding:8px 24px; border-radius:30px; font-weight:700; font-size:15px; }
  .status-confirmed  { background:#d4edda; color:#155724; }
  .status-preparing  { background:#fff3cd; color:#856404; }
  .status-shipped    { background:#cce5ff; color:#004085; }
  .status-delivered  { background:#d4edda; color:#155724; }
  .status-cancelled  { background:#f8d7da; color:#721c24; }
  .body { padding:0 40px 32px; }
  .order-box { background:#f8f9fa; border-radius:8px; padding:20px 24px; margin:20px 0; }
  .order-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #e9ecef; font-size:14px; }
  .order-row:last-child { border-bottom:none; font-weight:700; font-size:15px; }
  .order-row span:first-child { color:#6c757d; }
  .items-table { width:100%; border-collapse:collapse; margin:16px 0; font-size:14px; }
  .items-table th { text-align:left; padding:8px 0; border-bottom:2px solid #dee2e6; color:#6c757d; font-weight:600; font-size:12px; text-transform:uppercase; }
  .items-table td { padding:10px 0; border-bottom:1px solid #f0f0f0; }
  .btn { display:inline-block; margin:20px 0; padding:14px 32px; background:#2d6a4f; color:#fff !important; text-decoration:none; border-radius:8px; font-weight:700; font-size:15px; }
  .footer { background:#f8f9fa; padding:20px 40px; text-align:center; font-size:12px; color:#adb5bd; }
  .footer a { color:#2d6a4f; }
  @media(max-width:600px){ .header,.body,.footer{padding-left:20px;padding-right:20px;} }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <h1>🌾 COOP CA HEZOUWE</h1>
  </div>

  <div class="status-banner">
    @php
      $icons   = ['confirmed'=>'✅','preparing'=>'⚙️','shipped'=>'🚚','delivered'=>'🎉','cancelled'=>'❌'];
      $labels  = ['confirmed'=>'Commande confirmée','preparing'=>'En préparation','shipped'=>'Expédiée','delivered'=>'Livrée','cancelled'=>'Annulée'];
      $icon    = $icons[$newStatus]  ?? '📦';
      $label   = $labels[$newStatus] ?? 'Mise à jour';
    @endphp
    <div class="status-icon">{{ $icon }}</div>
    <div class="status-label status-{{ $newStatus }}">{{ $label }}</div>

    <p style="color:#495057;margin:16px 0 0;font-size:15px;">
      Bonjour <strong>{{ $order->customer_name }}</strong>,<br>
      votre commande <strong>{{ $order->order_number }}</strong> a été mise à jour.
    </p>
  </div>

  <div class="body">

    @if($newStatus === 'confirmed')
      <p style="color:#495057;">Votre paiement a été reçu et vérifié. Nous préparons votre commande dans les plus brefs délais.</p>
    @elseif($newStatus === 'preparing')
      <p style="color:#495057;">Votre commande est en cours de préparation. Vous recevrez une notification dès qu'elle sera expédiée.</p>
    @elseif($newStatus === 'shipped')
      <p style="color:#495057;">Votre commande est en route ! Notre livreur vous contactera pour convenir de la livraison.</p>
    @elseif($newStatus === 'delivered')
      <p style="color:#495057;">Votre commande a été livrée. Merci pour votre confiance ! 🌾</p>
    @elseif($newStatus === 'cancelled')
      <p style="color:#495057;">Votre commande a été annulée. Contactez-nous si vous avez des questions.</p>
    @endif

    <div class="order-box">
      <div class="order-row"><span>Numéro de commande</span><span>{{ $order->order_number }}</span></div>
      <div class="order-row"><span>Mode de paiement</span><span>
        @if($order->payment_method === 'mobile_money') Mobile Money
        @elseif($order->payment_method === 'bank_transfer') Virement bancaire
        @else Paiement à la livraison
        @endif
      </span></div>
      <div class="order-row"><span>Statut paiement</span><span>
        {{ $order->payment_status === 'paid' ? '✅ Payé' : '⏳ En attente' }}
      </span></div>
      <div class="order-row"><span>Livraison</span><span>{{ $order->city }}, {{ $order->address }}</span></div>
      <div class="order-row"><span>Total commande</span><span>{{ number_format($order->total, 0, ',', ' ') }} FCFA</span></div>
    </div>

    @if($order->items && $order->items->count())
    <table class="items-table">
      <thead>
        <tr>
          <th>Produit</th>
          <th style="text-align:center">Qté</th>
          <th style="text-align:right">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product_title }}</td>
          <td style="text-align:center">{{ $item->quantity }}</td>
          <td style="text-align:right">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    <div style="text-align:center">
      <a href="{{ url('/dashboard') }}" class="btn">Voir ma commande</a>
    </div>

    <p style="font-size:13px;color:#6c757d;margin-top:24px;">
      Une question ? Contactez-nous à
      <a href="mailto:contact@hezouwe.tg" style="color:#2d6a4f;">contact@hezouwe.tg</a>
      ou au <strong>+228 70 67 94 48</strong>.
    </p>
  </div>

  <div class="footer">
    © {{ date('Y') }} COOP CA HEZOUWE — Tagbega, Région Plateaux, TOGO<br>
    <a href="{{ url('/') }}">www.hezouwe.tg</a>
  </div>

</div>
</body>
</html>
