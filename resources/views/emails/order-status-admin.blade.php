<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mise à jour commande {{ $order->order_number }} — Admin HEZOUWE</title>
</head>
<body style="margin:0;padding:0;background:#eaecef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#eaecef;padding:28px 12px;">
<tr><td align="center">
<table width="640" cellpadding="0" cellspacing="0" style="max-width:640px;width:100%;">

  <!-- Bandeau admin -->
  <tr><td style="background:#1c2b3a;border-radius:10px 10px 0 0;padding:14px 32px;">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <img src="{{ url('/assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE" height="40"
               style="height:40px;width:auto;border-radius:6px;display:block;">
        </td>
        <td style="text-align:right;vertical-align:middle;">
          <span style="display:inline-block;background:#e67e22;color:#fff;font-size:10px;font-weight:900;padding:4px 14px;border-radius:4px;letter-spacing:1px;text-transform:uppercase;">
            ESPACE ADMINISTRATION
          </span>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Titre avec statut -->
  @php
    $icons  = ['confirmed'=>'✅','preparing'=>'⚙️','shipped'=>'🚚','delivered'=>'📦','cancelled'=>'❌'];
    $labels = [
      'confirmed' => 'Paiement vérifié — Commande confirmée',
      'preparing' => 'Commande passée en préparation',
      'shipped'   => 'Commande expédiée',
      'delivered' => 'Commande livrée',
      'cancelled' => 'Commande annulée',
    ];
    $bannerBg = [
      'confirmed' => '#27ae60',
      'preparing' => '#f39c12',
      'shipped'   => '#2980b9',
      'delivered' => '#1abc9c',
      'cancelled' => '#c0392b',
    ];
    $icon     = $icons[$newStatus]    ?? '📦';
    $label    = $labels[$newStatus]   ?? 'Statut mis à jour';
    $bgColor  = $bannerBg[$newStatus] ?? '#7f8c8d';
  @endphp
  <tr><td style="background:#2c3e50;padding:18px 32px 16px;">
    <p style="margin:0 0 4px;color:#f39c12;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">
      NOTIFICATION INTERNE — MISE À JOUR COMMANDE
    </p>
    <h1 style="margin:0;color:#fff;font-size:19px;font-weight:900;line-height:1.3;">
      {{ $icon }}&nbsp; {{ $label }}
    </h1>
    <p style="margin:6px 0 0;color:#95a5a6;font-size:13px;">
      N° <strong style="color:#f39c12;font-family:monospace;">{{ $order->order_number }}</strong>
      &nbsp;—&nbsp; le {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
    </p>
  </td></tr>

  <!-- Barre statut colorée -->
  <tr><td style="background:{{ $bgColor }};padding:10px 32px;">
    <p style="margin:0;color:#fff;font-size:13px;font-weight:800;">
      Statut mis à jour : <strong>{{ strtoupper($label) }}</strong>
      &nbsp;—&nbsp; Action générée depuis le tableau de bord admin
    </p>
  </td></tr>

  <!-- Client recap -->
  <tr><td style="background:#fff;padding:22px 32px 10px;">
    <p style="margin:0 0 12px;color:#2c3e50;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;border-bottom:2px solid #ecf0f1;padding-bottom:8px;">
      Client concerné
    </p>
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;color:#2c3e50;">
      <tr>
        <td style="padding:5px 0;width:36%;color:#7f8c8d;font-weight:700;">Nom</td>
        <td style="padding:5px 0;font-weight:800;">{{ $order->customer_name }}</td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:5px 8px;color:#7f8c8d;font-weight:700;">Email</td>
        <td style="padding:5px 8px;">
          <a href="mailto:{{ $order->customer_email }}" style="color:#2980b9;text-decoration:none;font-weight:700;">{{ $order->customer_email }}</a>
        </td>
      </tr>
      <tr>
        <td style="padding:5px 0;color:#7f8c8d;font-weight:700;">Téléphone</td>
        <td style="padding:5px 0;font-weight:700;">
          <a href="tel:{{ $order->customer_phone }}" style="color:#2c3e50;text-decoration:none;">{{ $order->customer_phone }}</a>
        </td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:5px 8px;color:#7f8c8d;font-weight:700;">Adresse livraison</td>
        <td style="padding:5px 8px;font-weight:700;">{{ $order->address }}, {{ $order->city }}</td>
      </tr>
    </table>
  </td></tr>

  <!-- Récapitulatif paiement -->
  <tr><td style="background:#fff;padding:14px 32px 10px;">
    <p style="margin:0 0 12px;color:#2c3e50;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;border-bottom:2px solid #ecf0f1;padding-bottom:8px;">
      Paiement & Montant
    </p>
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;color:#2c3e50;">
      <tr>
        <td style="padding:5px 0;color:#7f8c8d;font-weight:700;width:36%;">Mode de paiement</td>
        <td style="padding:5px 0;font-weight:700;">
          @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
          @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
          @else 🤝 Paiement à la livraison
          @endif
        </td>
      </tr>
      @if($order->transaction_id)
      <tr style="background:#f8f9fa;">
        <td style="padding:5px 8px;color:#7f8c8d;font-weight:700;">ID Transaction</td>
        <td style="padding:5px 8px;font-family:monospace;font-weight:800;color:#1c2b3a;">{{ $order->transaction_id }}</td>
      </tr>
      @endif
      <tr>
        <td style="padding:5px 0;color:#7f8c8d;font-weight:700;">Statut paiement</td>
        <td style="padding:5px 0;font-weight:800;">
          @if($order->payment_status === 'paid')
            <span style="color:#27ae60;">✅ Payé et validé</span>
          @elseif($order->payment_status === 'rejected')
            <span style="color:#c0392b;">❌ Rejeté</span>
          @else
            <span style="color:#f39c12;">⏳ En attente</span>
          @endif
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Articles -->
  @if($order->items && $order->items->count())
  <tr><td style="background:#fff;padding:14px 32px 10px;">
    <p style="margin:0 0 12px;color:#2c3e50;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;border-bottom:2px solid #ecf0f1;padding-bottom:8px;">
      Articles de la commande
    </p>
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
      <tr style="background:#2c3e50;">
        <th style="text-align:left;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;font-weight:800;">Produit</th>
        <th style="text-align:center;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;font-weight:800;">Qté</th>
        <th style="text-align:right;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;font-weight:800;">Total ligne</th>
      </tr>
      @foreach($order->items as $i => $item)
      <tr style="background:{{ $i % 2 === 0 ? '#fff' : '#f8f9fa' }};border-bottom:1px solid #ecf0f1;">
        <td style="padding:8px 10px;color:#2c3e50;font-weight:600;">{{ $item->product_title }}</td>
        <td style="padding:8px 10px;text-align:center;color:#7f8c8d;font-weight:700;">{{ $item->quantity }}</td>
        <td style="padding:8px 10px;text-align:right;color:#1c2b3a;font-weight:800;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
      </tr>
      @endforeach
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;margin-top:4px;">
      <tr>
        <td style="padding:6px 10px;color:#7f8c8d;text-align:right;">Sous-total</td>
        <td style="padding:6px 10px;text-align:right;font-weight:700;width:140px;white-space:nowrap;">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
      </tr>
      <tr>
        <td style="padding:4px 10px;color:#7f8c8d;text-align:right;">Livraison</td>
        <td style="padding:4px 10px;text-align:right;font-weight:700;white-space:nowrap;">
          @if($order->delivery_cost == 0) <span style="color:#27ae60;">Offerte</span>
          @else {{ number_format($order->delivery_cost, 0, ',', ' ') }} FCFA @endif
        </td>
      </tr>
      <tr style="background:#2c3e50;">
        <td style="padding:10px 10px;color:#ecf0f1;font-weight:900;text-align:right;font-size:14px;border-radius:4px 0 0 4px;">TOTAL</td>
        <td style="padding:10px 10px;text-align:right;color:#f39c12;font-weight:900;font-size:16px;border-radius:0 4px 4px 0;white-space:nowrap;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
      </tr>
    </table>
  </td></tr>
  @endif

  <!-- CTA admin -->
  <tr><td style="background:#f0f3f7;padding:20px 32px;text-align:center;border-top:3px solid #e67e22;">
    <a href="{{ url('/admin/orders/'.$order->id) }}"
       style="display:inline-block;padding:13px 36px;background:#e67e22;color:#fff;text-decoration:none;border-radius:6px;font-weight:900;font-size:14px;letter-spacing:.5px;">
      VOIR LA COMMANDE DANS L'ADMIN →
    </a>
    <p style="margin:10px 0 0;color:#95a5a6;font-size:11px;">
      <a href="{{ url('/admin/orders') }}" style="color:#e67e22;text-decoration:none;font-weight:700;">Toutes les commandes</a>
    </p>
  </td></tr>

  <!-- Footer interne -->
  <tr><td style="background:#1c2b3a;border-radius:0 0 10px 10px;padding:14px 32px;text-align:center;">
    <p style="margin:0 0 4px;color:rgba(255,255,255,0.5);font-size:11px;">
      Notification automatique interne — Ne pas répondre à cet email
    </p>
    <p style="margin:0;color:rgba(255,255,255,0.25);font-size:10px;">
      &copy; {{ date('Y') }} COOP CA HEZOUWE &nbsp;|&nbsp; Tableau de bord admin réservé au personnel autorisé
    </p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
