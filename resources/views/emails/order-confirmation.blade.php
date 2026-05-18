<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Confirmation commande â€” HEZOUWE</title></head>
<body style="margin:0;padding:0;background:#f0f4ef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ef;padding:32px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

  <!-- Header -->
  <tr><td style="background:#1a3a1a;border-radius:12px 12px 0 0;padding:28px 40px;text-align:center;">
    <p style="margin:0 0 4px;color:#d5a741;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">CoopÃ©rative du Riz Local</p>
    <h1 style="margin:0;color:#fff;font-size:24px;font-weight:900;">HEZOUWE</h1>
    <span style="display:inline-block;margin-top:12px;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;padding:4px 14px;border-radius:999px;">Commande reÃ§ue</span>
  </td></tr>

  <!-- Intro -->
  <tr><td style="background:#fff;padding:32px 40px 20px;">
    <h2 style="margin:0 0 6px;color:#1a3a1a;font-size:20px;font-weight:900;">Merci pour votre commande, {{ $order->customer_name }} !</h2>
    <p style="margin:0;color:#5a6b5c;font-size:14px;line-height:1.6;">
      Votre commande <strong style="color:#1a3a1a;">{{ $order->order_number }}</strong> a bien Ã©tÃ© enregistrÃ©e.
      @if($order->payment_method === 'bank_transfer')
      Veuillez effectuer votre virement bancaire pour que votre commande soit traitÃ©e.
      @elseif($order->payment_method === 'cash_on_delivery')
      Votre ID de transaction est en cours de vÃ©rification. Vous recevrez une confirmation par email.
      @endif
    </p>
  </td></tr>

  <!-- Payment instructions -->
  @if($order->payment_method === 'cash_on_delivery')
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <div style="background:#fff8e1;border:1px solid #ffd54f;border-radius:8px;padding:18px 20px;">
      <p style="margin:0 0 8px;color:#b8860b;font-size:13px;font-weight:900;text-transform:uppercase;">Paiement Ã  la livraison â€” ID de transaction</p>
      <p style="margin:0 0 8px;color:#5a4510;font-size:13px;line-height:1.6;">
        Votre ID de transaction soumis : <strong style="background:#fffde7;padding:2px 8px;border-radius:4px;font-family:monospace;">{{ $order->transaction_id ?? 'N/A' }}</strong>
      </p>
      <p style="margin:0;color:#5a4510;font-size:12px;">
        Notre Ã©quipe va vÃ©rifier votre paiement de <strong>{{ number_format($order->total / 2, 0, ',', ' ') }} FCFA</strong> (50% de {{ number_format($order->total, 0, ',', ' ') }} FCFA). Vous serez notifiÃ©(e) par email une fois validÃ©.
      </p>
    </div>
  </td></tr>
  @elseif($order->payment_method === 'bank_transfer')
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <div style="background:#e8f4fd;border:1px solid #90caf9;border-radius:8px;padding:18px 20px;">
      <p style="margin:0 0 12px;color:#1565c0;font-size:13px;font-weight:900;text-transform:uppercase;">Informations de virement bancaire</p>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td style="padding:4px 0;color:#424242;font-size:13px;width:140px;font-weight:700;">Titulaire :</td><td style="padding:4px 0;color:#17351a;font-size:13px;">COOP CA HEZOUWE</td></tr>
        <tr><td style="padding:4px 0;color:#424242;font-size:13px;font-weight:700;">Banque :</td><td style="padding:4px 0;color:#17351a;font-size:13px;">[Ã€ complÃ©ter par l'admin]</td></tr>
        <tr><td style="padding:4px 0;color:#424242;font-size:13px;font-weight:700;">NÂ° de compte :</td><td style="padding:4px 0;color:#17351a;font-size:13px;">[Ã€ complÃ©ter par l'admin]</td></tr>
        <tr><td style="padding:4px 0;color:#424242;font-size:13px;font-weight:700;">RÃ©fÃ©rence :</td><td style="padding:4px 0;color:#1565c0;font-size:13px;font-weight:900;">{{ $order->order_number }}</td></tr>
        <tr><td style="padding:8px 0 4px;color:#424242;font-size:13px;font-weight:700;">Montant exact :</td><td style="padding:8px 0 4px;color:#5cb85c;font-size:16px;font-weight:900;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td></tr>
      </table>
      <p style="margin:12px 0 0;color:#5a6b5c;font-size:12px;">Indiquez la rÃ©fÃ©rence <strong>{{ $order->order_number }}</strong> dans l'intitulÃ© du virement. Envoyez votre preuve Ã  <a href="mailto:contact@hezouwe.tg" style="color:#1565c0;">contact@hezouwe.tg</a></p>
    </div>
  </td></tr>
  @endif

  <!-- Order items -->
  <tr><td style="background:#fff;padding:0 40px 20px;">
    <p style="margin:0 0 12px;color:#1a3a1a;font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:0.5px;">Articles commandÃ©s</p>
    @foreach($order->items as $item)
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:8px;border:1px solid #e8eee3;border-radius:6px;overflow:hidden;">
      <tr>
        @if($item->product_image)
        <td width="56" style="padding:0;line-height:0;">
          <img src="{{ url($item->product_image) }}" alt="{{ $item->product_title }}" width="56" style="width:56px;height:56px;object-fit:cover;display:block;">
        </td>
        @endif
        <td style="padding:10px 14px;vertical-align:middle;">
          <p style="margin:0 0 2px;color:#17351a;font-size:13px;font-weight:900;">{{ $item->product_title }}</p>
          <p style="margin:0;color:#68746a;font-size:12px;">{{ $item->quantity }} Ã— {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</p>
        </td>
        <td align="right" style="padding:10px 14px;color:#17351a;font-size:13px;font-weight:900;white-space:nowrap;">
          {{ number_format($item->line_total, 0, ',', ' ') }} FCFA
        </td>
      </tr>
    </table>
    @endforeach
  </td></tr>

  <!-- Totals -->
  <tr><td style="background:#fff;padding:0 40px 32px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e8eee3;padding-top:12px;">
      <tr><td style="padding:4px 0;color:#68746a;font-size:13px;">Sous-total</td><td align="right" style="padding:4px 0;color:#17351a;font-size:13px;">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td></tr>
      <tr><td style="padding:4px 0;color:#68746a;font-size:13px;">Livraison</td><td align="right" style="padding:4px 0;color:#17351a;font-size:13px;">{{ $order->delivery_cost == 0 ? 'Gratuite' : number_format($order->delivery_cost, 0, ',', ' ').' FCFA' }}</td></tr>
      <tr><td style="padding:10px 0 4px;color:#1a3a1a;font-size:15px;font-weight:900;border-top:2px solid #e8eee3;">Total</td><td align="right" style="padding:10px 0 4px;color:#5cb85c;font-size:18px;font-weight:900;border-top:2px solid #e8eee3;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td></tr>
    </table>
  </td></tr>

  <!-- Delivery info -->
  <tr><td style="background:#f8faf7;border-top:1px solid #e8eee3;padding:20px 40px;">
    <p style="margin:0 0 6px;color:#1a3a1a;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:0.5px;">Adresse de livraison</p>
    <p style="margin:0;color:#5a6b5c;font-size:13px;line-height:1.6;">{{ $order->customer_name }} â€” {{ $order->customer_phone }}<br>{{ $order->address }}, {{ $order->city }}, TOGO</p>
  </td></tr>

  <!-- Footer -->
  <tr><td style="background:#0f2810;border-radius:0 0 12px 12px;padding:22px 40px;text-align:center;">
    <p style="margin:0 0 4px;color:rgba(255,255,255,0.5);font-size:12px;">Des questions ? Contactez-nous : <a href="mailto:contact@hezouwe.tg" style="color:#d5a741;text-decoration:none;">contact@hezouwe.tg</a></p>
    <p style="margin:0;color:rgba(255,255,255,0.3);font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE â€” Tous droits rÃ©servÃ©s</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
