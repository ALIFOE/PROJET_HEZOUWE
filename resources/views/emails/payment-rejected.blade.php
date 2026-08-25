<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paiement non validé — HEZOUWE</title>
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
    <span style="display:inline-block;margin-top:12px;background:#f5c6cb;color:#721c24;font-size:11px;font-weight:900;text-transform:uppercase;padding:5px 16px;border-radius:999px;">
      ⚠️ Action requise — Paiement non validé
    </span>
  </td></tr>

  <!-- Alert -->
  <tr><td style="background:#fff8f8;border-left:4px solid #f5c6cb;padding:20px 40px;">
    <p style="margin:0;color:#5a6b5c;font-size:14px;line-height:1.7;">
      Bonjour <strong style="color:#1a3a1a;">{{ $order->customer_name }}</strong>,
    </p>
    <p style="margin:10px 0 0;color:#5a6b5c;font-size:14px;line-height:1.7;">
      Nous avons examiné votre paiement pour la commande
      <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong>,
      mais nous n'avons pas pu le valider. Voici la raison communiquée par notre équipe :
    </p>
  </td></tr>

  <!-- Rejection reason -->
  <tr><td style="background:#fff;padding:20px 40px;">
    <div style="background:#fff0f0;border:1.5px solid #f5c6cb;border-radius:10px;padding:20px 24px;">
      <p style="margin:0 0 10px;color:#721c24;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">
        ⚠️ Motif du rejet
      </p>
      <p style="margin:0;color:#721c24;font-size:15px;line-height:1.6;font-weight:600;">{{ $order->rejection_reason }}</p>
    </div>
  </td></tr>

  <!-- What to do -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <p style="margin:0 0 14px;color:#1a3a1a;font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Que faire maintenant ?</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="36" valign="top" style="padding-bottom:16px;padding-right:14px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#2d6a4f;color:#fff;font-size:12px;font-weight:900;text-align:center;line-height:28px;">1</div>
        </td>
        <td style="padding-bottom:16px;border-bottom:1px solid #f0f4f0;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Corrigez votre ID de transaction</p>
          <p style="margin:0;color:#68746a;font-size:12px;line-height:1.6;">
            Connectez-vous à votre espace client et resoumetez le bon identifiant de transaction depuis votre tableau de bord, sans avoir à repasser une nouvelle commande.
          </p>
        </td>
      </tr>
      <tr>
        <td width="36" valign="top" style="padding-bottom:16px;padding-right:14px;padding-top:16px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#2d6a4f;color:#fff;font-size:12px;font-weight:900;text-align:center;line-height:28px;">2</div>
        </td>
        <td style="padding-bottom:16px;border-bottom:1px solid #f0f4f0;padding-top:16px;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Envoyez une capture d'écran</p>
          <p style="margin:0;color:#68746a;font-size:12px;line-height:1.6;">
            Si vous êtes certain(e) d'avoir effectué le paiement, envoyez une capture d'écran de votre transaction à
            <a href="mailto:contact@hezouwe.com" style="color:#2d6a4f;font-weight:700;">contact@hezouwe.com</a>.
          </p>
        </td>
      </tr>
      <tr>
        <td width="36" valign="top" style="padding-right:14px;padding-top:16px;">
          <div style="width:28px;height:28px;border-radius:50%;background:#d5a741;color:#1a3a1a;font-size:12px;font-weight:900;text-align:center;line-height:28px;">3</div>
        </td>
        <td style="padding-top:16px;">
          <p style="margin:0 0 3px;color:#17351a;font-size:13px;font-weight:900;">Effectuez un nouveau paiement si nécessaire</p>
          <p style="margin:0;color:#68746a;font-size:12px;line-height:1.6;">
            Si le premier paiement n'a pas abouti, effectuez un nouveau paiement et soumettez le nouvel identifiant depuis votre dashboard.
          </p>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Order details -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faf7;border:1px solid #e8eee3;border-radius:8px;overflow:hidden;">
      <tr style="background:#2d6a4f;">
        <td colspan="2" style="padding:12px 18px;color:#fff;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">Votre commande</td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;width:200px;">Numéro</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;font-family:monospace;">{{ $order->order_number }}</td>
      </tr>
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">Mode de paiement</td>
        <td style="padding:10px 18px;color:#17351a;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;">
          @if($order->payment_method === 'mobile_money') 📱 Mobile Money (FedaPay)
          @elseif($order->payment_method === 'bank_transfer') 🏦 Virement bancaire
          @else 🏠 Paiement à la livraison
          @endif
        </td>
      </tr>
      @if($order->transaction_id)
      <tr>
        <td style="padding:10px 18px;color:#68746a;font-size:13px;border-bottom:1px solid #e8eee3;">ID fourni (rejeté)</td>
        <td style="padding:10px 18px;color:#b42323;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid #e8eee3;font-family:monospace;">{{ $order->transaction_id }}</td>
      </tr>
      @endif
      <tr>
        <td style="padding:12px 18px;color:#1a3a1a;font-size:14px;font-weight:900;">Montant à régler</td>
        <td style="padding:12px 18px;color:#5cb85c;font-size:16px;font-weight:900;text-align:right;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
      </tr>
    </table>
  </td></tr>

  <!-- CTA -->
  <tr><td style="background:#fff;padding:20px 40px 28px;text-align:center;border-top:1px solid #e8eee3;">
    <a href="{{ url('/dashboard') }}"
       style="display:inline-block;padding:13px 32px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:8px;font-weight:900;font-size:14px;">
      Corriger mon paiement →
    </a>
  </td></tr>

  <!-- Contact -->
  <tr><td style="background:#f8faf7;padding:16px 40px;text-align:center;border-top:1px solid #e8eee3;">
    <p style="margin:0;color:#68746a;font-size:12px;">
      📧 <a href="mailto:contact@hezouwe.com" style="color:#2d6a4f;font-weight:700;">contact@hezouwe.com</a>
      &nbsp;|&nbsp; 📞 <strong>+228 70 67 94 48</strong>
      &nbsp;|&nbsp; 📱 <strong>+228 90 45 27 73</strong>
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
