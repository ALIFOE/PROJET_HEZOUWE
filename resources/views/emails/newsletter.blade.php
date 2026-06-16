<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background:#f0f4ef;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4ef;padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

        <!-- Header -->
        <tr>
          <td style="background:#1a3a1a;border-radius:12px 12px 0 0;padding:24px 40px;text-align:center;">
            <img src="{{ url('/assets/img/logo/logo_hezouwe.jpeg') }}" alt="HEZOUWE" height="60"
                 style="height:60px;width:auto;border-radius:8px;display:inline-block;margin-bottom:10px;">
            <div>
              <p style="margin:0 0 2px;color:#d5a741;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:2px;">Coopérative du Riz Local</p>
              <h1 style="margin:0;color:#fff;font-size:22px;font-weight:900;">COOP CA HEZOUWE</h1>
            </div>
            <div style="margin-top:16px;">
              @if($type === 'article')
                <span style="display:inline-block;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;padding:5px 14px;border-radius:999px;">Nouvel Article</span>
              @elseif($type === 'product')
                <span style="display:inline-block;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;padding:5px 14px;border-radius:999px;">Nouveau Produit</span>
              @else
                <span style="display:inline-block;background:#d5a741;color:#1a3a1a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;padding:5px 14px;border-radius:999px;">Nouveau Service</span>
              @endif
            </div>
          </td>
        </tr>

        <!-- Image -->
        @if($image)
        <tr>
          <td style="padding:0;line-height:0;">
            <img src="{{ url($image) }}" alt="{{ $title }}" width="600"
                 style="width:100%;max-width:600px;height:280px;object-fit:cover;display:block;">
          </td>
        </tr>
        @endif

        <!-- Content -->
        <tr>
          <td style="background:#ffffff;padding:40px 40px 32px;">
            <h2 style="margin:0 0 16px;color:#1a3a1a;font-size:22px;font-weight:900;line-height:1.3;">
              {{ $title }}
            </h2>
            <p style="margin:0 0 28px;color:#5a6b5c;font-size:15px;line-height:1.7;">
              {{ $excerpt }}
            </p>

            <!-- CTA Button -->
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td style="border-radius:8px;background:#5cb85c;">
                  <a href="{{ $link }}"
                     style="display:inline-block;padding:14px 32px;color:#ffffff;text-decoration:none;font-weight:900;font-size:15px;border-radius:8px;">
                    @if($type === 'article')Lire l'article &rarr;
                    @elseif($type === 'product')Voir le produit &rarr;
                    @else Decouvrir le service &rarr;
                    @endif
                  </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- Divider -->
        <tr>
          <td style="background:#ffffff;padding:0 40px;">
            <hr style="border:none;border-top:1px solid #e8eee3;margin:0;">
          </td>
        </tr>

        <!-- Contact band -->
        <tr>
          <td style="background:#ffffff;padding:24px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="padding:0 12px 0 0;" width="33%">
                  <p style="margin:0;color:#9aaa95;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Adresse</p>
                  <p style="margin:4px 0 0;color:#1a3a1a;font-size:12px;line-height:1.5;">Tagbega, Wahala<br>Region Plateaux, TOGO</p>
                </td>
                <td style="padding:0 12px;" width="33%">
                  <p style="margin:0;color:#9aaa95;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Telephone</p>
                  <p style="margin:4px 0 0;color:#1a3a1a;font-size:12px;">+228 70 67 94 48</p>
                </td>
                <td style="padding:0 0 0 12px;" width="33%">
                  <p style="margin:0;color:#9aaa95;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">Email</p>
                  <p style="margin:4px 0 0;font-size:12px;">
                    <a href="mailto:contact@hezouwe.tg" style="color:#5cb85c;text-decoration:none;">contact@hezouwe.tg</a>
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="background:#0f2810;border-radius:0 0 12px 12px;padding:24px 40px;text-align:center;">
            <p style="margin:0 0 8px;color:rgba(255,255,255,0.5);font-size:12px;">
              Vous recevez cet email car vous etes abonne(e) a la newsletter HEZOUWE.
            </p>
            <a href="{{ url('/newsletter/unsubscribe/' . $unsubscribeToken) }}"
               style="color:#d5a741;font-size:12px;text-decoration:underline;">
              Se desabonner
            </a>
            <p style="margin:16px 0 0;color:rgba(255,255,255,0.3);font-size:11px;">
              &copy; {{ date('Y') }} COOP CA HEZOUWE &mdash; Tous droits reserves
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
