<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Vérification email — HEZOUWE</title></head>
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

      <!-- Icon -->
      <tr><td style="background:#fff;padding:40px 40px 0;text-align:center;">
        <div style="width:72px;height:72px;border-radius:50%;background:#e8f5e9;border:2px solid #c3ddc0;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <span style="font-size:32px;">✉️</span>
        </div>
        <p style="margin:0 0 8px;color:#d5a741;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">Dernière étape</p>
        <h2 style="margin:0 0 16px;color:#1a3a1a;font-size:22px;font-weight:900;">Vérifiez votre adresse email</h2>
        <p style="margin:0 0 28px;color:#5a6b5c;font-size:15px;line-height:1.7;">
          Merci de vous être inscrit(e) sur COOP CA HEZOUWE. Cliquez sur le bouton ci-dessous pour activer votre compte et accéder à votre espace.
        </p>
        <table cellpadding="0" cellspacing="0" style="margin:0 auto 32px;">
          <tr><td style="border-radius:8px;background:#1a3a1a;">
            <a href="{{ $url }}" style="display:inline-block;padding:16px 40px;color:#fff;text-decoration:none;font-weight:900;font-size:16px;border-radius:8px;">
              Vérifier mon adresse email
            </a>
          </td></tr>
        </table>
        <p style="margin:0 0 8px;color:#9aaa95;font-size:13px;">Ce lien expire dans 60 minutes.</p>
        <p style="margin:0 0 28px;color:#9aaa95;font-size:12px;">Si vous n'avez pas créé de compte, ignorez cet email.</p>
      </td></tr>

      <!-- Steps -->
      <tr><td style="background:#fff;padding:0 40px 32px;">
        <div style="background:#f8faf7;border:1px solid #e5ece2;border-radius:8px;padding:20px;">
          <p style="margin:0 0 14px;color:#1a3a1a;font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:0.5px;">Comment ça marche ?</p>
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="28" style="vertical-align:top;padding-right:12px;padding-top:2px;">
                <div style="width:24px;height:24px;border-radius:50%;background:#1a3a1a;color:#fff;font-size:11px;font-weight:900;text-align:center;line-height:24px;">1</div>
              </td>
              <td style="padding-bottom:12px;">
                <p style="margin:0;color:#17351a;font-size:13px;font-weight:700;">Cliquez sur le bouton "Vérifier mon adresse email"</p>
              </td>
            </tr>
            <tr>
              <td width="28" style="vertical-align:top;padding-right:12px;padding-top:2px;">
                <div style="width:24px;height:24px;border-radius:50%;background:#1a3a1a;color:#fff;font-size:11px;font-weight:900;text-align:center;line-height:24px;">2</div>
              </td>
              <td style="padding-bottom:12px;">
                <p style="margin:0;color:#17351a;font-size:13px;font-weight:700;">Votre compte est activé automatiquement</p>
              </td>
            </tr>
            <tr>
              <td width="28" style="vertical-align:top;padding-right:12px;">
                <div style="width:24px;height:24px;border-radius:50%;background:#5cb85c;color:#fff;font-size:11px;font-weight:900;text-align:center;line-height:24px;">3</div>
              </td>
              <td>
                <p style="margin:0;color:#17351a;font-size:13px;font-weight:700;">Accédez à votre tableau de bord COOP CA HEZOUWE</p>
              </td>
            </tr>
          </table>
        </div>
      </td></tr>

      <!-- Footer -->
      <tr><td style="background:#0f2810;border-radius:0 0 12px 12px;padding:24px 40px;text-align:center;">
        <p style="margin:0 0 8px;color:rgba(255,255,255,0.5);font-size:12px;">Tagbega, Wahala — Région Plateaux, TOGO | contact@hezouwe.com</p>
        <p style="margin:0;color:rgba(255,255,255,0.3);font-size:11px;">&copy; {{ date('Y') }} COOP CA HEZOUWE — Tous droits réservés</p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
