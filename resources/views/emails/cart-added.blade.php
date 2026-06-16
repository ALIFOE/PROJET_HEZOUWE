<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Produit ajouté au panier — HEZOUWE</title></head>
<body style="margin:0;padding:0;background:#f0f4ef;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ef;padding:32px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">
  <tr><td style="background:#1a3a1a;border-radius:12px 12px 0 0;padding:24px 40px;text-align:center;">
    <img src="{{ url('/assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE" height="60"
         style="height:60px;width:auto;border-radius:8px;display:inline-block;margin-bottom:10px;">
    <div>
      <p style="margin:0 0 2px;color:#d5a741;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">Coopérative du Riz Local</p>
      <h1 style="margin:0;color:#fff;font-size:22px;font-weight:900;">COOP CA HEZOUWE</h1>
    </div>
    <span style="display:inline-block;margin-top:12px;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;padding:5px 16px;border-radius:999px;">Panier mis à jour</span>
  </td></tr>
  <tr><td style="background:#fff;padding:32px 40px 20px;">
    <h2 style="margin:0 0 8px;color:#1a3a1a;font-size:18px;font-weight:900;">Bonjour {{ $userName }} !</h2>
    <p style="margin:0;color:#5a6b5c;font-size:14px;line-height:1.6;">Vous venez d'ajouter le produit suivant à votre panier :</p>
  </td></tr>
  <tr><td style="background:#fff;padding:0 40px 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="border:2px solid #5cb85c;border-radius:8px;overflow:hidden;">
      <tr>
        @if(!empty($product['image']))
        <td width="100" style="padding:0;line-height:0;">
          <img src="{{ url($product['image']) }}" alt="{{ $product['title'] }}" width="100" style="width:100px;height:100px;object-fit:cover;display:block;">
        </td>
        @endif
        <td style="padding:16px 20px;vertical-align:middle;">
          <p style="margin:0 0 4px;color:#1a3a1a;font-size:16px;font-weight:900;">{{ $product['title'] }}</p>
          <p style="margin:0;color:#5cb85c;font-size:18px;font-weight:900;">{{ number_format($product['price'] ?? 0, 0, ',', ' ') }} FCFA</p>
        </td>
      </tr>
    </table>
  </td></tr>
  @if(count($cartItems) > 0)
  <tr><td style="background:#fff;padding:0 40px 24px;">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr><td colspan="2" style="padding-bottom:10px;color:#1a3a1a;font-size:13px;font-weight:900;">Total panier ({{ count($cartItems) }} article{{ count($cartItems) > 1 ? 's' : '' }})</td></tr>
      <tr><td style="color:#5cb85c;font-size:18px;font-weight:900;">{{ number_format($cartTotal, 0, ',', ' ') }} FCFA</td>
          <td align="right"><a href="{{ url('/checkout') }}" style="display:inline-block;padding:10px 22px;background:#5cb85c;color:#fff;text-decoration:none;font-weight:900;font-size:13px;border-radius:6px;">Finaliser →</a></td>
      </tr>
    </table>
  </td></tr>
  @endif
  <tr><td style="background:#fff;padding:0 40px 32px;text-align:center;border-bottom:1px solid #e8eee3;">
    <a href="{{ url('/shop-cart') }}" style="color:#5cb85c;font-size:13px;text-decoration:none;font-weight:700;">Voir mon panier complet</a>
  </td></tr>
  <tr><td style="background:#0f2810;border-radius:0 0 12px 12px;padding:22px 40px;text-align:center;">
    <p style="margin:0 0 4px;color:rgba(255,255,255,0.5);font-size:12px;">contact@hezouwe.tg | +228 70 67 94 48</p>
    <p style="margin:0;color:rgba(255,255,255,0.3);font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
