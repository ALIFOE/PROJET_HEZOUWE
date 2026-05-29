<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle commande — Espace Admin HEZOUWE</title>
</head>
<body style="margin:0;padding:0;background:#eaecef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#eaecef;padding:28px 12px;">
<tr><td align="center">
<table width="640" cellpadding="0" cellspacing="0" style="max-width:640px;width:100%;">

  <!-- Bandeau admin identitaire -->
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

  <!-- Titre alerte -->
  <tr><td style="background:#2c3e50;padding:18px 32px 16px;">
    <p style="margin:0 0 4px;color:#f39c12;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">
      NOTIFICATION INTERNE — ACTION REQUISE
    </p>
    <h1 style="margin:0;color:#fff;font-size:20px;font-weight:900;line-height:1.3;">
      Nouvelle commande reçue
    </h1>
    <p style="margin:6px 0 0;color:#95a5a6;font-size:13px;">
      N° <strong style="color:#f39c12;font-family:monospace;">{{ $order->order_number }}</strong>
      &nbsp;—&nbsp; le {{ \Carbon\Carbon::parse($order->created_at)->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
    </p>
  </td></tr>

  <!-- Bandeau statut paiement -->
  @php
    $pm = $order->payment_method;
    $pmLabel = match($pm) {
      'mobile_money'    => 'Mobile Money (FedaPay)',
      'bank_transfer'   => 'Virement bancaire',
      default           => 'Paiement à la livraison',
    };
    $pmIcon = match($pm) {
      'mobile_money'  => '📱',
      'bank_transfer' => '🏦',
      default         => '🤝',
    };
    $pmBg = $pm === 'mobile_money' ? '#1abc9c' : ($pm === 'bank_transfer' ? '#3498db' : '#95a5a6');
  @endphp
  <tr><td style="background:{{ $pmBg }};padding:10px 32px;">
    <p style="margin:0;color:#fff;font-size:13px;font-weight:800;">
      {{ $pmIcon }}&nbsp; Mode de paiement : {{ $pmLabel }}
      @if($order->transaction_id)
        &nbsp;|&nbsp; ID : <span style="font-family:monospace;background:rgba(0,0,0,.2);padding:2px 8px;border-radius:3px;">{{ $order->transaction_id }}</span>
      @endif
    </p>
  </td></tr>

  <!-- Section : Informations client -->
  <tr><td style="background:#fff;padding:22px 32px 6px;">
    <p style="margin:0 0 14px;color:#2c3e50;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;border-bottom:2px solid #ecf0f1;padding-bottom:8px;">
      Informations client
    </p>
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;color:#2c3e50;">
      <tr>
        <td style="padding:5px 0;width:36%;color:#7f8c8d;font-weight:700;">Nom complet</td>
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
        <td style="padding:5px 0;font-weight:800;">
          <a href="tel:{{ $order->customer_phone }}" style="color:#2c3e50;text-decoration:none;">{{ $order->customer_phone }}</a>
        </td>
      </tr>
      <tr style="background:#f8f9fa;">
        <td style="padding:5px 8px;color:#7f8c8d;font-weight:700;">Ville</td>
        <td style="padding:5px 8px;font-weight:700;">{{ $order->city }}</td>
      </tr>
      <tr>
        <td style="padding:5px 0;color:#7f8c8d;font-weight:700;">Adresse livraison</td>
        <td style="padding:5px 0;font-weight:700;">{{ $order->address }}</td>
      </tr>
      @if($order->notes)
      <tr style="background:#fff8e1;">
        <td style="padding:5px 8px;color:#7f8c8d;font-weight:700;vertical-align:top;">Note client</td>
        <td style="padding:5px 8px;font-style:italic;color:#555;">{{ $order->notes }}</td>
      </tr>
      @endif
    </table>
  </td></tr>

  <!-- Section : Articles -->
  <tr><td style="background:#fff;padding:18px 32px 6px;">
    <p style="margin:0 0 12px;color:#2c3e50;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;border-bottom:2px solid #ecf0f1;padding-bottom:8px;">
      Détail de la commande
    </p>
    @if($order->items && $order->items->count())
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
      <tr style="background:#2c3e50;">
        <th style="text-align:left;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;letter-spacing:.5px;font-weight:800;border-radius:4px 0 0 0;">Produit</th>
        <th style="text-align:center;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;letter-spacing:.5px;font-weight:800;">Qté</th>
        <th style="text-align:right;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;letter-spacing:.5px;font-weight:800;">P.U.</th>
        <th style="text-align:right;padding:8px 10px;color:#ecf0f1;font-size:11px;text-transform:uppercase;letter-spacing:.5px;font-weight:800;border-radius:0 4px 0 0;">Total</th>
      </tr>
      @foreach($order->items as $i => $item)
      <tr style="background:{{ $i % 2 === 0 ? '#fff' : '#f8f9fa' }};border-bottom:1px solid #ecf0f1;">
        <td style="padding:9px 10px;color:#2c3e50;font-weight:600;">{{ $item->product_title }}</td>
        <td style="padding:9px 10px;text-align:center;color:#7f8c8d;font-weight:700;">{{ $item->quantity }}</td>
        <td style="padding:9px 10px;text-align:right;color:#555;">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
        <td style="padding:9px 10px;text-align:right;color:#1c2b3a;font-weight:800;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
      </tr>
      @endforeach
    </table>
    @endif
  </td></tr>

  <!-- Totaux -->
  <tr><td style="background:#fff;padding:0 32px 22px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;margin-top:2px;">
      <tr>
        <td colspan="2" style="width:55%;"></td>
        <td style="padding:5px 10px;color:#7f8c8d;text-align:right;">Sous-total</td>
        <td style="padding:5px 10px;text-align:right;font-weight:700;white-space:nowrap;">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td style="padding:5px 10px;color:#7f8c8d;text-align:right;">Livraison</td>
        <td style="padding:5px 10px;text-align:right;font-weight:700;white-space:nowrap;">
          @if($order->delivery_cost == 0)
            <span style="color:#27ae60;">Offerte</span>
          @else
            {{ number_format($order->delivery_cost, 0, ',', ' ') }} FCFA
          @endif
        </td>
      </tr>
      <tr style="background:#2c3e50;border-radius:4px;">
        <td colspan="2"></td>
        <td style="padding:10px 10px;color:#ecf0f1;font-weight:900;text-align:right;font-size:14px;border-radius:4px 0 0 4px;">TOTAL</td>
        <td style="padding:10px 10px;text-align:right;color:#f39c12;font-weight:900;font-size:16px;border-radius:0 4px 4px 0;white-space:nowrap;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
      </tr>
    </table>
  </td></tr>

  <!-- CTA admin -->
  <tr><td style="background:#f0f3f7;padding:20px 32px;text-align:center;border-top:3px solid #e67e22;">
    <p style="margin:0 0 12px;color:#7f8c8d;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">
      Action requise dans le tableau de bord
    </p>
    <a href="{{ url('/admin/orders/'.$order->id) }}"
       style="display:inline-block;padding:13px 36px;background:#e67e22;color:#fff;text-decoration:none;border-radius:6px;font-weight:900;font-size:14px;letter-spacing:.5px;">
      OUVRIR LA COMMANDE DANS L'ADMIN →
    </a>
    <p style="margin:10px 0 0;color:#95a5a6;font-size:11px;">
      Ou accéder à la <a href="{{ url('/admin/orders') }}" style="color:#e67e22;text-decoration:none;font-weight:700;">liste des commandes</a>
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
