<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouveau message de contact — Espace Admin HEZOUWE</title>
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
          <span style="display:inline-block;background:#2d6a4f;color:#fff;font-size:10px;font-weight:900;padding:4px 14px;border-radius:4px;letter-spacing:1px;text-transform:uppercase;">
            FORMULAIRE DE CONTACT
          </span>
        </td>
      </tr>
    </table>
  </td></tr>

  <!-- Titre -->
  <tr><td style="background:#2c3e50;padding:18px 32px 16px;">
    <p style="margin:0 0 4px;color:#5cb85c;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">
      NOUVEAU MESSAGE REÇU
    </p>
    <h1 style="margin:0;color:#fff;font-size:20px;font-weight:900;line-height:1.3;">
      {{ $data['subject'] }}
    </h1>
    <p style="margin:6px 0 0;color:#95a5a6;font-size:13px;">
      Envoyé le {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}
    </p>
  </td></tr>

  <!-- Détails expéditeur -->
  <tr><td style="background:#fff;padding:24px 32px 8px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
      <tr>
        <td style="padding:8px 0;color:#7f8c8d;font-size:13px;width:140px;">Nom</td>
        <td style="padding:8px 0;color:#1a3a1a;font-size:13px;font-weight:700;">{{ $data['name'] }}</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:#7f8c8d;font-size:13px;">Email</td>
        <td style="padding:8px 0;color:#1a3a1a;font-size:13px;font-weight:700;">
          <a href="mailto:{{ $data['email'] }}" style="color:#2d6a4f;text-decoration:none;">{{ $data['email'] }}</a>
        </td>
      </tr>
      @if(!empty($data['phone']))
      <tr>
        <td style="padding:8px 0;color:#7f8c8d;font-size:13px;">Téléphone</td>
        <td style="padding:8px 0;color:#1a3a1a;font-size:13px;font-weight:700;">{{ $data['phone'] }}</td>
      </tr>
      @endif
      <tr>
        <td style="padding:8px 0;color:#7f8c8d;font-size:13px;">Type de demande</td>
        <td style="padding:8px 0;color:#1a3a1a;font-size:13px;font-weight:700;">{{ $data['inquiryTypeLabel'] }}</td>
      </tr>
    </table>
  </td></tr>

  <!-- Message -->
  <tr><td style="background:#fff;padding:16px 32px 28px;">
    <p style="margin:0 0 8px;color:#7f8c8d;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">
      Message
    </p>
    <div style="background:#f8faf7;border:1px solid #e5ece2;border-radius:8px;padding:16px 18px;color:#33402c;font-size:14px;line-height:1.7;white-space:pre-wrap;">{{ $data['message'] }}</div>
  </td></tr>

  <!-- CTA réponse -->
  <tr><td style="background:#f0f3f7;padding:20px 32px;text-align:center;border-top:3px solid #2d6a4f;">
    <p style="margin:0 0 12px;color:#7f8c8d;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">
      Répondez directement à cet email pour contacter {{ $data['name'] }}
    </p>
    <a href="mailto:{{ $data['email'] }}"
       style="display:inline-block;padding:13px 36px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:6px;font-weight:900;font-size:14px;letter-spacing:.5px;">
      RÉPONDRE À {{ strtoupper($data['name']) }} →
    </a>
  </td></tr>

  <!-- Footer interne -->
  <tr><td style="background:#1c2b3a;border-radius:0 0 10px 10px;padding:14px 32px;text-align:center;">
    <p style="margin:0 0 4px;color:rgba(255,255,255,0.5);font-size:11px;">
      Message envoyé depuis le formulaire de contact de hezouwe.com
    </p>
    <p style="margin:0;color:rgba(255,255,255,0.25);font-size:10px;">
      &copy; {{ date('Y') }} COOP CA HEZOUWE
    </p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
