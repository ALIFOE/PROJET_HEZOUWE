<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paiement confirmé — HEZOUWE</title>
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
    <span style="display:inline-block;margin-top:12px;background:#5cb85c;color:#fff;font-size:11px;font-weight:900;text-transform:uppercase;padding:5px 16px;border-radius:999px;">
      ✓ Paiement confirmé
    </span>
  </td></tr>

  <!-- Success message -->
  <tr><td style="background:#fff;padding:36px 40px 24px;text-align:center;">
    <div style="width:72px;height:72px;border-radius:50%;background:#e8f5e9;border:2px solid #5cb85c;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:34px;line-height:72px;">
      ✅
    </div>
    <h2 style="margin:0 0 10px;color:#1a3a1a;font-size:22px;font-weight:900;">Votre paiement est confirmé !</h2>
    <p style="margin:0;color:#5a6b5c;font-size:14px;line-height:1.7;">
      Bonjour <strong style="color:#1a3a1a;">{{ $order->customer_name }}</strong>,
      votre paiement pour la commande <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong>
      a été vérifié et validé par notre équipe. Votre commande est maintenant
      <strong style="color:#5cb85c;">confirmée</strong>.
    </p>
  </td></tr>

  <!-- Status badges -->
  <tr><td style="background:#fff;padding:0 40px 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#e8f5e9;border:1px solid #c3ddc0;border-radius:8px;overflow:hidden;">
      <tr>
        <td style="padding:12px 18px;border-bottom:1px solid #c3ddc0;width:50%;">
          <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;">Commande</p>
          <p style="margin:0;color:#1a3a1a;font-size:14px;font-weight:900;font-family:monospace;">{{ $order->order_number }}</p>
        </td>
        <td style="padding:12px 18px;border-bottom:1px solid #c3ddc0;">
          <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;">Statut</p>
          <p style="margin:0;color:#24782b;font-size:14px;font-weight:900;">Confirmée ✓</p>
        </td>
      </tr>
      <tr>
        <td style="padding:12px 18px;">
          <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;">Paiement</p>
          <p style="margin:0;color:#24782b;font-size:14px;font-weight:900;">Vérifié ✓</p>
        </td>
        <td style="padding:12px 18px;">
          <p style="margin:0 0 3px;color:#68746a;font-size:11px;font-weight:900;text-transform:uppercase;">Total payé</p>
          <p style="margin:0;color:#5cb85c;font-size:16px;font-weight:900;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</p>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Receipt -->
  @if($order->items && $order->items->count())
  <tr><td style="background:#fff;padding:0 40px 24px;">
    <p style="margin:0 0 12px;color:#1a3a1a;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">
      🧾 Reçu de paiement
    </p>
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
          @if($order->delivery_cost > 0) {{ number_format($order->delivery_cost, 0, ',', ' ') }} FCFA
          @else <span style="color:#5cb85c;">Gratuite</span>
          @endif
        </td>
      </tr>
      <tr>
        <td colspan="3" style="padding:12px 0 6px;color:#1a3a1a;font-size:15px;font-weight:900;border-top:2px solid #e8eee3;">Total payé</td>
        <td style="padding:12px 0 6px;text-align:right;color:#2d6a4f;font-size:17px;font-weight:900;border-top:2px solid #e8eee3;">
          {{ number_format($order->total, 0, ',', ' ') }} FCFA
        </td>
      </tr>
    </table>
    <div style="background:#f0faf0;border-radius:6px;padding:10px 14px;margin-top:10px;font-size:12px;color:#5a6b5c;">
      <strong style="color:#1a3a1a;">Mode de paiement :</strong>
      @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
      @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
      @else 🏠 Paiement à la livraison
      @endif
      @if($order->transaction_id)
        &nbsp;— ID : <strong style="color:#1a3a1a;font-family:monospace;">{{ $order->transaction_id }}</strong>
      @endif
      &nbsp;— Date : <strong style="color:#1a3a1a;">{{ $order->updated_at->format('d/m/Y à H:i') }}</strong>
    </div>
  </td></tr>
  @endif

  <!-- Next steps -->
  <tr><td style="background:#fff;padding:0 40px 28px;">
    <p style="margin:0 0 14px;color:#1a3a1a;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Prochaines étapes</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="36" valign="top" style="padding-bottom:14px;padding-right:14px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#5cb85c;color:#fff;font-size:12px;font-weight:900;text-align:center;line-height:28px;">1</div>
        </td>
        <td style="padding-bottom:14px;border-bottom:1px solid #f0f4f0;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Préparation de votre commande</p>
          <p style="margin:0;color:#68746a;font-size:12px;">Notre équipe prépare vos articles avec soin.</p>
        </td>
      </tr>
      <tr>
        <td width="36" valign="top" style="padding-bottom:14px;padding-right:14px;padding-top:14px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#5cb85c;color:#fff;font-size:12px;font-weight:900;text-align:center;line-height:28px;">2</div>
        </td>
        <td style="padding-bottom:14px;border-bottom:1px solid #f0f4f0;padding-top:14px;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Expédition vers {{ $order->city }}</p>
          <p style="margin:0;color:#68746a;font-size:12px;">Adresse : {{ $order->address }}</p>
        </td>
      </tr>
      <tr>
        <td width="36" valign="top" style="padding-right:14px;padding-top:14px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#d5a741;color:#1a3a1a;font-size:12px;font-weight:900;text-align:center;line-height:28px;">3</div>
        </td>
        <td style="padding-top:14px;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Livraison à domicile</p>
          <p style="margin:0;color:#68746a;font-size:12px;">
            @if($order->payment_method === 'cash_on_delivery')
              Solde restant à payer à la livraison :
              <strong style="color:#1a3a1a;">{{ number_format($order->total / 2, 0, ',', ' ') }} FCFA</strong>
            @else
              Vous serez contacté(e) pour confirmer le créneau de livraison.
            @endif
          </p>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- CTA -->
  <tr><td style="background:#fff;padding:0 40px 28px;text-align:center;border-top:1px solid #e8eee3;">
    <a href="{{ url('/orders/'.$order->id.'/receipt') }}"
       style="display:inline-block;padding:13px 32px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;margin-right:10px;">
      📥 Télécharger le reçu
    </a>
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block;padding:13px 32px;background:#f8faf7;color:#1a3a1a;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;border:1.5px solid #dfe8db;">
      Mon espace client
    </a>
  </td></tr>

  <!-- Contact -->
  <tr><td style="background:#f8faf7;padding:16px 40px;text-align:center;border-top:1px solid #e8eee3;">
    <p style="margin:0;color:#68746a;font-size:12px;">
      Des questions ? <a href="mailto:contact@hezouwe.tg" style="color:#2d6a4f;font-weight:700;">contact@hezouwe.tg</a>
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
