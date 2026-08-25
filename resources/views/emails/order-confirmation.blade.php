<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmation de commande — HEZOUWE</title>
</head>
<body style="margin:0;padding:0;background:#f0f4ef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ef;padding:32px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

  <!-- Header -->
  <tr><td style="background:#1a3a1a;border-radius:12px 12px 0 0;padding:24px 40px;text-align:center;">
    <img src="{{ url('/assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE" height="60"
         style="height:60px;width:auto;border-radius:8px;display:inline-block;margin-bottom:10px;">
    <div>
      <p style="margin:0 0 2px;color:#d5a741;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">Coopérative du Riz Local</p>
      <h1 style="margin:0;color:#fff;font-size:22px;font-weight:900;">COOP CA HEZOUWE</h1>
    </div>
    <span style="display:inline-block;margin-top:12px;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;padding:5px 16px;border-radius:999px;">
      ✓ Commande reçue
    </span>
  </td></tr>

  <!-- Intro -->
  <tr><td style="background:#fff;padding:32px 40px 20px;">
    <h2 style="margin:0 0 8px;color:#1a3a1a;font-size:20px;font-weight:900;">Merci pour votre commande, {{ $order->customer_name }} !</h2>
    <p style="margin:0;color:#5a6b5c;font-size:14px;line-height:1.7;">
      Votre commande <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong> a bien été enregistrée le
      <strong style="color:#1a3a1a;">{{ $order->created_at->format('d/m/Y à H:i') }}</strong>.
      @if($order->payment_method === 'bank_transfer')
        Veuillez effectuer votre virement bancaire pour que votre commande soit traitée.
      @elseif($order->payment_method === 'cash_on_delivery')
        Votre ID de transaction est en cours de vérification. Vous recevrez une confirmation par email.
      @else
        Votre paiement Mobile Money est en cours de traitement.
      @endif
    </p>
  </td></tr>

  <!-- Payment instructions -->
  @if($order->payment_method === 'cash_on_delivery')
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <div style="background:#fff8e1;border-left:4px solid #ffd54f;border-radius:8px;padding:18px 20px;">
      <p style="margin:0 0 8px;color:#b8860b;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Paiement à la livraison — ID de transaction</p>
      <p style="margin:0 0 8px;color:#5a4510;font-size:13px;line-height:1.6;">
        Votre ID de transaction soumis :
        <strong style="background:#fffde7;padding:2px 8px;border-radius:4px;font-family:monospace;color:#1a3a1a;">{{ $order->transaction_id ?? 'N/A' }}</strong>
      </p>
      <p style="margin:0;color:#5a4510;font-size:12px;">
        Notre équipe va vérifier votre paiement de
        <strong>{{ number_format($order->total / 2, 0, ',', ' ') }} FCFA</strong>
        (50% de {{ number_format($order->total, 0, ',', ' ') }} FCFA).
        Vous serez notifié(e) par email une fois validé.
      </p>
    </div>
  </td></tr>
  @elseif($order->payment_method === 'bank_transfer')
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <div style="background:#e8f4fd;border-left:4px solid #90caf9;border-radius:8px;padding:18px 20px;">
      <p style="margin:0 0 12px;color:#1565c0;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Informations de virement bancaire</p>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td style="padding:5px 0;color:#424242;font-size:13px;width:160px;font-weight:700;">Titulaire :</td><td style="padding:5px 0;color:#17351a;font-size:13px;font-weight:700;">COOP CA HEZOUWE</td></tr>
        <tr><td style="padding:5px 0;color:#424242;font-size:13px;font-weight:700;">Banque :</td><td style="padding:5px 0;color:#17351a;font-size:13px;">BANQUE ATLANTIQUE TOGO</td></tr>
        <tr><td style="padding:5px 0;color:#424242;font-size:13px;font-weight:700;">Référence :</td><td style="padding:5px 0;color:#1565c0;font-size:13px;font-weight:900;font-family:monospace;">{{ $order->order_number }}</td></tr>
        <tr><td style="padding:8px 0 4px;color:#424242;font-size:13px;font-weight:700;">Montant exact :</td><td style="padding:8px 0 4px;color:#5cb85c;font-size:16px;font-weight:900;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td></tr>
      </table>
      <p style="margin:12px 0 0;color:#5a6b5c;font-size:12px;">
        Indiquez la référence <strong>{{ $order->order_number }}</strong> dans l'intitulé du virement.
        Envoyez votre preuve à <a href="mailto:contact@hezouwe.com" style="color:#1565c0;">contact@hezouwe.com</a>
      </p>
    </div>
  </td></tr>
  @endif

  <!-- Order summary box -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faf7;border:1px solid #e8eee3;border-radius:8px;overflow:hidden;">
      <tr style="background:#2d6a4f;">
        <td colspan="2" style="padding:12px 18px;color:#fff;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Récapitulatif de la commande</td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Numéro</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;font-family:monospace;">{{ $order->order_number }}</td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Mode de paiement</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;">
          @if($order->payment_method === 'mobile_money') 📱 Mobile Money
          @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
          @else 🏠 Paiement à la livraison
          @endif
        </td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Livraison</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;">{{ $order->city }}</td>
      </tr>
      <tr>
        <td style="padding:12px 18px;color:#1a3a1a;font-size:14px;font-weight:900;">Total commandé</td>
        <td style="padding:12px 18px;color:#5cb85c;font-size:16px;font-weight:900;text-align:right;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
      </tr>
    </table>
  </td></tr>

  <!-- Order items -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <p style="margin:0 0 12px;color:#1a3a1a;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Articles commandés</p>
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
      <tr style="border-bottom:2px solid #e8eee3;">
        <th style="text-align:left;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Produit</th>
        <th style="text-align:center;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Qté</th>
        <th style="text-align:right;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Prix unit.</th>
        <th style="text-align:right;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Total</th>
      </tr>
      @foreach($order->items as $item)
      <tr style="border-bottom:1px solid #f0f4f0;">
        <td style="padding:10px 0;color:#17351a;font-weight:600;">{{ $item->product_title }}</td>
        <td style="padding:10px 0;text-align:center;color:#5a6b5c;">{{ $item->quantity }}</td>
        <td style="padding:10px 0;text-align:right;color:#5a6b5c;">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
        <td style="padding:10px 0;text-align:right;color:#17351a;font-weight:700;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
      </tr>
      @endforeach
      <tr style="border-top:1px solid #e8eee3;">
        <td colspan="3" style="padding:8px 0;color:#68746a;font-size:12px;">Frais de livraison</td>
        <td style="padding:8px 0;text-align:right;color:#68746a;font-size:12px;">
          {{ $order->delivery_cost == 0 ? 'Gratuite' : number_format($order->delivery_cost, 0, ',', ' ').' FCFA' }}
        </td>
      </tr>
      <tr>
        <td colspan="3" style="padding:12px 0 6px;color:#1a3a1a;font-size:15px;font-weight:900;border-top:2px solid #e8eee3;">Total</td>
        <td style="padding:12px 0 6px;text-align:right;color:#5cb85c;font-size:17px;font-weight:900;border-top:2px solid #e8eee3;">
          {{ number_format($order->total, 0, ',', ' ') }} FCFA
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Delivery info -->
  <tr><td style="background:#f8faf7;border-top:1px solid #e8eee3;padding:18px 40px;">
    <p style="margin:0 0 4px;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Adresse de livraison</p>
    <p style="margin:0;color:#5a6b5c;font-size:13px;line-height:1.6;">
      {{ $order->customer_name }} — {{ $order->customer_phone }}<br>
      {{ $order->address }}, {{ $order->city }}, TOGO
    </p>
  </td></tr>

  <!-- CTA -->
  <tr><td style="background:#fff;padding:24px 40px;text-align:center;border-top:1px solid #e8eee3;">
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block;padding:13px 32px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;">
      Suivre ma commande →
    </a>
  </td></tr>

  <!-- Contact -->
  <tr><td style="background:#f8faf7;padding:16px 40px;text-align:center;">
    <p style="margin:0;color:#68746a;font-size:12px;">
      Des questions ? <a href="mailto:contact@hezouwe.com" style="color:#2d6a4f;font-weight:700;">contact@hezouwe.com</a>
      &nbsp;|&nbsp; <strong>+228 70 67 94 48</strong>
    </p>
  </td></tr>

  <!-- Footer -->
  <tr><td style="background:#0f2810;border-radius:0 0 12px 12px;padding:20px 40px;text-align:center;">
    <p style="margin:0 0 4px;color:rgba(255,255,255,0.5);font-size:12px;">Tagbega, Wahala — Région Plateaux, TOGO</p>
    <p style="margin:0;color:rgba(255,255,255,0.3);font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE — Tous droits réservés</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
