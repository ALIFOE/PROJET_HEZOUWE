<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paiement non validé</title>
<style>
  body { margin:0; padding:0; background:#f4f4f4; font-family:'Segoe UI',Arial,sans-serif; }
  .wrapper { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#2d6a4f; padding:32px 40px; text-align:center; }
  .header h1 { color:#fff; margin:0; font-size:22px; letter-spacing:.5px; }
  .alert-banner { background:#fff3cd; border-left:4px solid #ffc107; padding:20px 40px; display:flex; align-items:center; gap:14px; }
  .alert-icon { font-size:32px; flex-shrink:0; }
  .alert-banner h2 { margin:0 0 4px; color:#856404; font-size:1.1rem; }
  .alert-banner p { margin:0; color:#856404; font-size:0.9rem; }
  .body { padding:24px 40px 32px; }
  .order-box { background:#f8f9fa; border-radius:8px; padding:20px 24px; margin:20px 0; }
  .order-row { display:flex; justify-content:space-between; padding:7px 0; border-bottom:1px solid #e9ecef; font-size:14px; }
  .order-row:last-child { border-bottom:none; }
  .order-row span:first-child { color:#6c757d; }
  .reason-box { background:#fff8f8; border:1.5px solid #f5c6cb; border-radius:8px; padding:16px 20px; margin:20px 0; }
  .reason-box .reason-label { font-weight:700; color:#721c24; margin-bottom:6px; font-size:0.9rem; text-transform:uppercase; letter-spacing:.5px; }
  .reason-box .reason-text { color:#721c24; font-size:0.95rem; line-height:1.5; }
  .steps { margin:20px 0; padding:0; list-style:none; }
  .steps li { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #f0f0f0; font-size:0.92rem; color:#495057; }
  .steps li:last-child { border-bottom:none; }
  .step-num { background:#2d6a4f; color:#fff; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; flex-shrink:0; margin-top:1px; }
  .btn { display:inline-block; margin:20px 0 8px; padding:14px 32px; background:#2d6a4f; color:#fff !important; text-decoration:none; border-radius:8px; font-weight:700; font-size:15px; }
  .footer { background:#f8f9fa; padding:20px 40px; text-align:center; font-size:12px; color:#adb5bd; }
  .footer a { color:#2d6a4f; }
  @media(max-width:600px){ .header,.body,.footer,.alert-banner{padding-left:20px;padding-right:20px;} }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <h1>🌾 COOP CA HEZOUWE</h1>
  </div>

  <div class="alert-banner">
    <div class="alert-icon">⚠️</div>
    <div>
      <h2>Paiement non validé</h2>
      <p>Commande {{ $order->order_number }} — Action requise de votre part</p>
    </div>
  </div>

  <div class="body">
    <p style="color:#495057;">Bonjour <strong>{{ $order->customer_name }}</strong>,</p>
    <p style="color:#495057;">Nous avons examiné votre paiement pour la commande <strong>{{ $order->order_number }}</strong>, mais nous n'avons pas pu le valider. Voici la raison :</p>

    <div class="reason-box">
      <div class="reason-label">⚠️ Motif du rejet</div>
      <div class="reason-text">{{ $order->rejection_reason }}</div>
    </div>

    <p style="color:#495057;font-weight:700;margin-bottom:10px;">Que faire maintenant ?</p>
    <ul class="steps">
      <li>
        <span class="step-num">1</span>
        <span>Vérifiez l'identifiant de transaction fourni et assurez-vous qu'il est exact.</span>
      </li>
      <li>
        <span class="step-num">2</span>
        <span>Contactez-nous avec le bon identifiant de transaction ou une capture d'écran de votre paiement.</span>
      </li>
      <li>
        <span class="step-num">3</span>
        <span>Ou effectuez un nouveau paiement et soumettez le nouvel identifiant de transaction.</span>
      </li>
    </ul>

    <div class="order-box">
      <div class="order-row"><span>Numéro de commande</span><span><strong>{{ $order->order_number }}</strong></span></div>
      <div class="order-row"><span>Mode de paiement</span><span>
        @if($order->payment_method === 'mobile_money') Mobile Money (FedaPay)
        @elseif($order->payment_method === 'bank_transfer') Virement bancaire
        @else Paiement à la livraison
        @endif
      </span></div>
      @if($order->transaction_id)
      <div class="order-row"><span>ID de transaction fourni</span><span><strong>{{ $order->transaction_id }}</strong></span></div>
      @endif
      <div class="order-row"><span>Montant</span><span><strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong></span></div>
    </div>

    <div style="text-align:center">
      <a href="{{ url('/dashboard') }}" class="btn">Voir ma commande</a>
    </div>

    <p style="font-size:13px;color:#6c757d;margin-top:24px;">
      Contactez-nous directement :<br>
      📧 <a href="mailto:contact@hezouwe.tg" style="color:#2d6a4f;">contact@hezouwe.tg</a> &nbsp;|&nbsp;
      📞 <strong>+228 70 67 94 48</strong> &nbsp;|&nbsp;
      📱 <strong>+228 90 45 27 73</strong>
    </p>
  </div>

  <div class="footer">
    © {{ date('Y') }} COOP CA HEZOUWE — Tagbega, Région Plateaux, TOGO<br>
    <a href="{{ url('/') }}">www.hezouwe.tg</a>
  </div>

</div>
</body>
</html>
