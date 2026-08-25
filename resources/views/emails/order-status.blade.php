<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mise à jour de votre commande — HEZOUWE</title>
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
  </td></tr>

  <!-- Status banner -->
  @php
    $icons  = ['confirmed'=>'✅','preparing'=>'⚙️','shipped'=>'🚚','delivered'=>'🎉','cancelled'=>'❌'];
    $labels = ['confirmed'=>'Commande confirmée','preparing'=>'En préparation','shipped'=>'Expédiée','delivered'=>'Livrée','cancelled'=>'Annulée'];
    $colors = ['confirmed'=>'#d4edda','preparing'=>'#fff3cd','shipped'=>'#cce5ff','delivered'=>'#d4edda','cancelled'=>'#f8d7da'];
    $texts  = ['confirmed'=>'#155724','preparing'=>'#856404','shipped'=>'#004085','delivered'=>'#155724','cancelled'=>'#721c24'];
    $icon   = $icons[$newStatus]  ?? '📦';
    $label  = $labels[$newStatus] ?? 'Mise à jour';
    $bg     = $colors[$newStatus] ?? '#f8f9fa';
    $color  = $texts[$newStatus]  ?? '#333';
  @endphp
  <tr><td style="background:#fff;padding:32px 40px 20px;text-align:center;">
    <div style="font-size:52px;line-height:1;">{{ $icon }}</div>
    <div style="display:inline-block;margin:14px 0 0;padding:8px 24px;background:{{ $bg }};color:{{ $color }};border-radius:30px;font-weight:900;font-size:15px;">
      {{ $label }}
    </div>
    <p style="color:#495057;margin:16px 0 0;font-size:15px;line-height:1.6;">
      Bonjour <strong style="color:#1a3a1a;">{{ $order->customer_name }}</strong>,<br>
      votre commande <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong> a été mise à jour.
    </p>
  </td></tr>

  <!-- Status message -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <div style="background:#f8faf7;border-left:4px solid #2d6a4f;border-radius:0 8px 8px 0;padding:16px 20px;">
      @if($newStatus === 'confirmed')
        <p style="margin:0;color:#155724;font-size:14px;line-height:1.7;">
          🎉 Votre paiement a été reçu et vérifié avec succès. Nous préparons votre commande dans les plus brefs délais.
          Vous recevrez une notification dès qu'elle sera en cours de préparation.
        </p>
      @elseif($newStatus === 'preparing')
        <p style="margin:0;color:#495057;font-size:14px;line-height:1.7;">
          ⚙️ Votre commande est en cours de préparation par notre équipe.
          Vous recevrez une notification dès qu'elle sera expédiée.
        </p>
      @elseif($newStatus === 'shipped')
        <p style="margin:0;color:#004085;font-size:14px;line-height:1.7;">
          🚚 Votre commande est en route vers <strong>{{ $order->city }}</strong> !
          Notre livreur vous contactera pour convenir de la livraison à l'adresse :<br>
          <strong>{{ $order->address }}</strong>.
        </p>
      @elseif($newStatus === 'delivered')
        <p style="margin:0;color:#155724;font-size:14px;line-height:1.7;">
          🎉 Votre commande a été livrée avec succès. Merci de votre confiance !
          N'hésitez pas à nous laisser votre avis ou à passer une nouvelle commande.
        </p>
      @elseif($newStatus === 'cancelled')
        <p style="margin:0;color:#721c24;font-size:14px;line-height:1.7;">
          Votre commande a été annulée. Si vous pensez qu'il s'agit d'une erreur
          ou si vous avez des questions, contactez-nous immédiatement.
        </p>
      @endif
    </div>
  </td></tr>

  <!-- Order details -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faf7;border:1px solid #e8eee3;border-radius:8px;overflow:hidden;">
      <tr style="background:#2d6a4f;">
        <td colspan="2" style="padding:12px 18px;color:#fff;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Détails de la commande</td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;width:200px;">Numéro de commande</td>
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
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Statut paiement</td>
        <td style="padding:10px 18px;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;">
          @if($order->payment_status === 'paid')
            <span style="color:#155724;">✅ Payé</span>
          @else
            <span style="color:#856404;">⏳ En attente</span>
          @endif
        </td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Livraison</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;">{{ $order->city }}</td>
      </tr>
      <tr>
        <td style="padding:12px 18px;color:#1a3a1a;font-size:14px;font-weight:900;">Total commande</td>
        <td style="padding:12px 18px;color:#5cb85c;font-size:16px;font-weight:900;text-align:right;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
      </tr>
    </table>
  </td></tr>

  <!-- Items -->
  @if($order->items && $order->items->count())
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <p style="margin:0 0 10px;color:#1a3a1a;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Articles</p>
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
      <tr style="border-bottom:2px solid #e8eee3;">
        <th style="text-align:left;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Produit</th>
        <th style="text-align:center;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Qté</th>
        <th style="text-align:right;padding:8px 0;color:#68746a;font-size:11px;text-transform:uppercase;font-weight:900;">Total</th>
      </tr>
      @foreach($order->items as $item)
      <tr style="border-bottom:1px solid #f0f4f0;">
        <td style="padding:10px 0;color:#17351a;font-weight:600;">{{ $item->product_title }}</td>
        <td style="padding:10px 0;text-align:center;color:#5a6b5c;">{{ $item->quantity }}</td>
        <td style="padding:10px 0;text-align:right;color:#17351a;font-weight:700;">{{ number_format($item->line_total, 0, ',', ' ') }} FCFA</td>
      </tr>
      @endforeach
    </table>
  </td></tr>
  @endif

  <!-- CTA -->
  <tr><td style="background:#fff;padding:20px 40px 28px;text-align:center;border-top:1px solid #e8eee3;">
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block;padding:13px 32px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;">
      Voir ma commande →
    </a>
  </td></tr>

  <!-- Contact -->
  <tr><td style="background:#f8faf7;padding:16px 40px;text-align:center;border-top:1px solid #e8eee3;">
    <p style="margin:0;color:#68746a;font-size:12px;">
      Une question ? <a href="mailto:contact@hezouwe.com" style="color:#2d6a4f;font-weight:700;">contact@hezouwe.com</a>
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
