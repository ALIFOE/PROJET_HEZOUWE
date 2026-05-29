<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle commande — Admin HEZOUWE</title>
</head>
<body style="margin:0;padding:0;background:#f0f4ef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ef;padding:32px 16px;">
<tr><td align="center">
<table width="620" cellpadding="0" cellspacing="0" style="max-width:620px;width:100%;">

  <!-- Header -->
  <tr><td style="background:#1a3a1a;border-radius:12px 12px 0 0;padding:20px 40px;text-align:center;">
    <img src="{{ url('/assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE" height="54"
         style="height:54px;width:auto;border-radius:8px;display:inline-block;margin-bottom:8px;">
    <div style="display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;">
      <h1 style="margin:0;color:#fff;font-size:20px;font-weight:900;">HEZOUWE — Tableau de bord Admin</h1>
      <span style="display:inline-block;background:#5cb85c;color:#fff;font-size:10px;font-weight:900;padding:4px 12px;border-radius:12px;letter-spacing:.5px;text-transform:uppercase;">
        🛒 Nouvelle commande
      </span>
    </div>
  </td></tr>

  <!-- Alert -->
  <tr><td style="background:#d4edda;border-left:4px solid #28a745;padding:16px 40px;">
    <p style="margin:0;color:#155724;font-size:14px;font-weight:700;">
      🛒 Une nouvelle commande vient d'être passée et attend votre traitement.
    </p>
  </td></tr>

  <!-- Client info -->
  <tr><td style="background:#fff;padding:24px 40px 16px;">
    <p style="margin:0 0 14px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Informations client</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="width:50%;padding-bottom:10px;">
          <div style="background:#f8faf7;border-radius:8px;padding:12px 16px;">
            <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:700;text-transform:uppercase;">Nom</p>
            <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;">{{ $order->customer_name }}</p>
          </div>
        </td>
        <td style="width:50%;padding-left:10px;padding-bottom:10px;">
          <div style="background:#f8faf7;border-radius:8px;padding:12px 16px;">
            <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:700;text-transform:uppercase;">Email</p>
            <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;">{{ $order->customer_email }}</p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-bottom:10px;">
          <div style="background:#f8faf7;border-radius:8px;padding:12px 16px;">
            <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:700;text-transform:uppercase;">Téléphone</p>
            <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;">{{ $order->customer_phone }}</p>
          </div>
        </td>
        <td style="padding-left:10px;padding-bottom:10px;">
          <div style="background:#f8faf7;border-radius:8px;padding:12px 16px;">
            <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:700;text-transform:uppercase;">Ville</p>
            <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;">{{ $order->city }}</p>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div style="background:#f8faf7;border-radius:8px;padding:12px 16px;">
            <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:700;text-transform:uppercase;">Adresse</p>
            <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;">{{ $order->address }}</p>
          </div>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Payment info -->
  <tr><td style="background:#fff;padding:8px 40px 16px;">
    <p style="margin:0 0 12px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Paiement</p>
    <div style="border:2px solid #ffc107;background:#fff9e6;border-radius:8px;padding:14px 18px;">
      <p style="margin:0 0 4px;color:#856404;font-size:11px;font-weight:900;text-transform:uppercase;">Mode de paiement</p>
      <p style="margin:0 0 6px;color:#856404;font-size:15px;font-weight:900;">
        @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
        @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
        @else 🏠 Paiement à la livraison
        @endif
      </p>
      @if($order->transaction_id)
      <p style="margin:0;color:#856404;font-size:13px;">
        ID Transaction : <strong style="font-family:monospace;">{{ $order->transaction_id }}</strong>
      </p>
      @endif
    </div>
  </td></tr>

  <!-- Items -->
  <tr><td style="background:#fff;padding:8px 40px 16px;">
    <p style="margin:0 0 12px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Articles commandés</p>
    @if($order->items && $order->items->count())
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
      <tr style="border-bottom:2px solid #dee2e6;">
        <th style="text-align:left;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;letter-spacing:.5px;">Produit</th>
        <th style="text-align:center;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;letter-spacing:.5px;">Qté</th>
        <th style="text-align:right;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;letter-spacing:.5px;">Prix unit.</th>
        <th style="text-align:right;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;letter-spacing:.5px;">Total</th>
      </tr>
      @foreach($order->items as $item)
      <tr style="border-bottom:1px solid #f0f0f0;">
        <td style="padding:10px 0;color:#333;font-weight:600;">{{ $item->product_title }}</td>
        <td style="padding:10px 0;text-align:center;color:#555;">{{ $item->quantity }}</td>
        <td style="padding:10px 0;text-align:right;color:#555;">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
        <td style="padding:10px 0;text-align:right;color:#1a3a1a;font-weight:700;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
      </tr>
      @endforeach
    </table>
    @endif
  </td></tr>

  <!-- Total -->
  <tr><td style="background:#fff;padding:0 40px 24px;">
    <div style="background:#f0faf0;border-radius:8px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;">
      <span style="color:#6c757d;font-size:14px;">Total commande</span>
      <strong style="font-size:1.2rem;color:#2d6a4f;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong>
    </div>
  </td></tr>

  <!-- CTA -->
  <tr><td style="background:#fff;padding:0 40px 28px;text-align:center;border-top:1px solid #e8eee3;">
    <a href="{{ url('/admin/orders/'.$order->id) }}"
       style="display:inline-block;padding:13px 32px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;">
      Voir et traiter la commande →
    </a>
  </td></tr>

  <!-- Footer -->
  <tr><td style="background:#f8faf7;padding:14px 40px;text-align:center;border-top:1px solid #e8eee3;">
    <p style="margin:0;color:#adb5bd;font-size:12px;">
      Notification automatique — COOP CA HEZOUWE &nbsp;|&nbsp;
      <a href="{{ url('/admin/orders') }}" style="color:#2d6a4f;">Tableau de bord admin</a>
    </p>
  </td></tr>
  <tr><td style="background:#0f2810;border-radius:0 0 12px 12px;padding:16px 40px;text-align:center;">
    <p style="margin:0;color:rgba(255,255,255,0.3);font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE — Tous droits réservés</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
