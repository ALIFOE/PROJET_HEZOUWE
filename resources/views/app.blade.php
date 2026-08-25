<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="COOP CA HEZOUWE">
    <meta name="description" content="{{ config('seo.default_description') }}">
    <title inertia>{{ $page['title'] ?? config('seo.default_title') }}</title>

    @if (config('seo.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('seo.google_site_verification') }}">
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo_hezouwe.jpeg') }}">

    <!-- Bootstrap min.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Magnific Popup.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- MeanMenu.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <!-- Odometer.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <!-- Swiper Bundle.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <!-- Nice Select.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <!-- Main.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    <meta property="og:site_name" content="{{ config('seo.site_name') }}">
    <meta property="og:locale" content="{{ config('seo.locale') }}">

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('seo.organization.name'),
            'url' => config('app.url'),
            'logo' => asset('assets/img/logo/logo_hezouwe.jpeg'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('seo.organization.address'),
                'addressCountry' => 'TG',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => config('seo.organization.phone'),
                'email' => config('seo.organization.email'),
                'contactType' => 'customer service',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @if (config('seo.ga4_id'))
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            // Consent Mode v2 : rien n'est autorisé tant que le visiteur n'a pas répondu au bandeau.
            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'ad_user_data': 'denied',
                'ad_personalization': 'denied',
                'analytics_storage': 'denied',
                'wait_for_update': 500
            });
        </script>
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('seo.ga4_id') }}"></script>
        <script>
            gtag('js', new Date());
            gtag('config', '{{ config('seo.ga4_id') }}', { anonymize_ip: true });
        </script>
    @endif

    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia

    @if (config('seo.ga4_id'))
        <div id="cookie-consent-banner" class="cookie-consent-banner" hidden>
            <p class="cookie-consent-text">
                Nous utilisons des cookies de mesure d'audience (Google Analytics) pour comprendre comment le site est utilisé et l'améliorer. Vous pouvez accepter ou refuser ce suivi à tout moment.
            </p>
            <div class="cookie-consent-actions">
                <button type="button" id="cookie-consent-reject" class="cookie-consent-btn cookie-consent-btn-reject">Refuser</button>
                <button type="button" id="cookie-consent-accept" class="cookie-consent-btn cookie-consent-btn-accept">Accepter</button>
            </div>
        </div>
        <style>
            .cookie-consent-banner {
                position: fixed;
                left: 16px;
                right: 16px;
                bottom: 16px;
                z-index: 99999;
                max-width: 720px;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 16px;
                background: #ffffff;
                border: 1px solid #e2e6df;
                border-radius: 10px;
                padding: 18px 20px;
                box-shadow: 0 12px 40px rgba(20, 30, 15, .18);
                font-family: inherit;
            }
            .cookie-consent-banner[hidden] { display: none; }
            .cookie-consent-text {
                flex: 1 1 320px;
                margin: 0;
                font-size: .92rem;
                line-height: 1.5;
                color: #33402c;
            }
            .cookie-consent-actions {
                display: flex;
                gap: 10px;
                flex: 0 0 auto;
            }
            .cookie-consent-btn {
                cursor: pointer;
                border-radius: 6px;
                padding: 10px 18px;
                font-size: .88rem;
                font-weight: 600;
                border: 1px solid var(--theme-color, #5B8C51);
                transition: opacity .2s ease;
            }
            .cookie-consent-btn:hover { opacity: .85; }
            .cookie-consent-btn-reject {
                background: #ffffff;
                color: var(--theme-color, #5B8C51);
            }
            .cookie-consent-btn-accept {
                background: var(--theme-color, #5B8C51);
                color: #ffffff;
            }
        </style>
        <script>
            (function () {
                var STORAGE_KEY = 'hezouwe_cookie_consent';

                function applyConsent(status) {
                    if (typeof gtag !== 'function') return;
                    gtag('consent', 'update', {
                        'analytics_storage': status === 'accepted' ? 'granted' : 'denied',
                        'ad_storage': 'denied',
                        'ad_user_data': 'denied',
                        'ad_personalization': 'denied'
                    });
                }

                function saveChoice(status) {
                    try { localStorage.setItem(STORAGE_KEY, status); } catch (e) {}
                    applyConsent(status);
                    var banner = document.getElementById('cookie-consent-banner');
                    if (banner) banner.hidden = true;
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var stored = null;
                    try { stored = localStorage.getItem(STORAGE_KEY); } catch (e) {}

                    if (stored === 'accepted' || stored === 'rejected') {
                        applyConsent(stored);
                        return;
                    }

                    var banner = document.getElementById('cookie-consent-banner');
                    if (!banner) return;
                    banner.hidden = false;

                    document.getElementById('cookie-consent-accept').addEventListener('click', function () {
                        saveChoice('accepted');
                    });
                    document.getElementById('cookie-consent-reject').addEventListener('click', function () {
                        saveChoice('rejected');
                    });
                });
            })();
        </script>
    @endif

    <!-- jQuery and Scripts - loaded after Inertia -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('assets/js/splitType.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
