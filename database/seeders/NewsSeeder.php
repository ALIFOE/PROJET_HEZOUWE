<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $newsList = [
            [
                'slug'       => '5000-clients-satisfaits',
                'title'      => 'HEZOUWE atteint 5 000 clients satisfaits en Afrique de l\'Ouest',
                'category'   => 'Croissance',
                'tag'        => ['Clients', 'Afrique de l\'Ouest', 'Croissance', 'Riz Local'],
                'author'     => 'Équipe HEZOUWE',
                'date'       => '2026-03-15',
                'read'       => '4 min',
                'comments'   => 5,
                'image'      => '/assets/img/inner-page/news/news-01.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-01.jpg',
                'excerpt'    => 'Grâce à la confiance de nos partenaires distributeurs et de nos clients fidèles, HEZOUWE franchit un cap historique avec 5 000 foyers approvisionnés en riz local de qualité à travers le TOGO et les pays voisins.',
                'intro'      => 'C\'est une étape majeure pour COOP CA HEZOUWE. Depuis sa création en 2023, la coopérative n\'a cessé de grandir, portée par la qualité de ses produits, la confiance de ses producteurs partenaires et l\'engagement de son équipe. Aujourd\'hui, nous célébrons le cap des 5 000 clients satisfaits répartis au TOGO, au Bénin, au Ghana et au Burkina Faso.',
                'body'       => [
                    'Ce succès est le fruit d\'un travail collectif. Les 30 producteurs membres de la coopérative ont cultivé, récolté et livré un riz de qualité premium, certifié par l\'ITRA, qui répond aux exigences des consommateurs modernes en quête de traçabilité et d\'authenticité.',
                    'Notre réseau de distribution s\'est considérablement développé ces derniers mois, avec l\'intégration de nouveaux revendeurs dans les marchés de Lomé, Atakpamé, Kpalimé et Sokodé. Parallèlement, nos partenariats avec des supermarchés et des boutiques spécialisées ont permis de toucher une clientèle urbaine à fort pouvoir d\'achat.',
                    '"Chaque sac de riz HEZOUWE qui part de nos entrepôts représente un effort collectif, une passion pour notre terroir et un engagement envers nos clients", déclare le président de la coopérative. "Ce cap des 5 000 clients nous encourage à aller encore plus loin."',
                ],
                'quote'      => 'Le riz HEZOUWE n\'est pas seulement un aliment, c\'est une promesse de qualité faite par 30 producteurs togolais à chaque foyer qui nous fait confiance.',
                'image2'     => '/assets/img/inner-page/news/news-02.jpg',
                'image3'     => '/assets/img/inner-page/news/news-03.jpg',
                'conclusion' => 'HEZOUWE poursuit son développement avec l\'objectif d\'atteindre 10 000 foyers approvisionnés d\'ici fin 2026, en renforçant ses capacités de transformation et en élargissant son réseau de distribution.',
            ],
            [
                'slug'       => 'certification-itra-riz-etuve',
                'title'      => 'Nouvelle certification ITRA pour notre riz étuvé — une première au TOGO',
                'category'   => 'Certification',
                'tag'        => ['ITRA', 'Certification', 'Riz Étuvé', 'Qualité'],
                'author'     => 'Direction Qualité',
                'date'       => '2026-03-10',
                'read'       => '5 min',
                'comments'   => 3,
                'image'      => '/assets/img/inner-page/news/news-02.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-02.jpg',
                'excerpt'    => 'HEZOUWE décroche la certification ITRA pour son riz étuvé, devenant l\'une des premières coopératives togolaises à obtenir cette double reconnaissance pour ses produits riz blanc et riz étuvé.',
                'intro'      => 'Après plusieurs mois d\'audits rigoureux conduits par les équipes de l\'Institut Togolais de Recherche Agronomique (ITRA), COOP CA HEZOUWE a officiellement reçu la certification ITRA pour l\'ensemble de sa gamme de riz étuvé.',
                'body'       => [
                    'La certification ITRA pour le riz étuvé est particulièrement exigeante. Elle impose un contrôle strict du processus de précuisson à la vapeur, du taux d\'humidité final, de l\'absence de résidus chimiques et d\'un conditionnement hermétique garantissant la conservation optimale du produit.',
                    'Les auditeurs de l\'ITRA ont inspecté l\'ensemble de notre chaîne de production : des parcelles des producteurs partenaires jusqu\'aux lignes de conditionnement, en passant par les unités de transformation.',
                    'Cette certification ouvre de nouvelles opportunités commerciales pour HEZOUWE, notamment l\'accès aux marchés institutionnels (cantines scolaires, hôpitaux, administrations) et aux circuits d\'exportation vers les pays voisins.',
                ],
                'quote'      => 'La certification ITRA est la preuve que le riz togolais peut rivaliser avec les meilleurs standards internationaux. Nous en sommes fiers et nous continuerons à maintenir cette excellence.',
                'image2'     => '/assets/img/inner-page/news/news-01.jpg',
                'image3'     => '/assets/img/inner-page/news/news-sm-03.jpg',
                'conclusion' => 'HEZOUWE envisage à présent d\'étendre sa certification aux sous-produits du riz (son, balles) et d\'obtenir des labels supplémentaires pour l\'exportation en Europe et aux États-Unis.',
            ],
            [
                'slug'       => '30-producteurs-unis',
                'title'      => '30 producteurs unis : la force qui fait la différence de la coopérative HEZOUWE',
                'category'   => 'Coopérative',
                'tag'        => ['Producteurs', 'Coopérative', 'Solidarité', 'Agriculture'],
                'author'     => 'Comité de Direction',
                'date'       => '2026-03-02',
                'read'       => '6 min',
                'comments'   => 8,
                'image'      => '/assets/img/inner-page/news/news-03.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-03.jpg',
                'excerpt'    => 'Portrait de la force humaine de HEZOUWE : 30 producteurs de la région de Tagbega qui ont décidé de s\'unir pour transformer le riz local togolais et améliorer leurs conditions de vie.',
                'intro'      => 'Derrière chaque sac de riz HEZOUWE, il y a une histoire. L\'histoire de 30 femmes et hommes de la région de Tagbega, dans la Région des Plateaux, qui ont décidé en 2023 de mettre leurs terres, leurs savoir-faire et leurs ambitions en commun pour créer quelque chose de grand : COOP CA HEZOUWE.',
                'body'       => [
                    'Ces producteurs, aux profils variés — agriculteurs de longue date, jeunes diplômés revenus au village, femmes cheffes de ménage — partagent tous la même conviction : le riz local togolais est un trésor qui mérite d\'être mis en valeur.',
                    'La coopérative a changé la donne. En mutualisant leurs productions, les membres négocient désormais collectivement des prix d\'achat garantis, accèdent à des équipements modernes de transformation et bénéficient d\'un accompagnement technique continu. Les revenus moyens des producteurs membres ont augmenté de 40% depuis la création de la coopérative.',
                    'Au-delà de l\'aspect économique, c\'est aussi une transformation sociale. Les décisions sont prises collectivement en assemblée générale, chaque voix compte.',
                ],
                'quote'      => 'Seul, on va plus vite. Ensemble, on va plus loin. HEZOUWE, c\'est la preuve vivante que la solidarité peut transformer l\'agriculture togolaise.',
                'image2'     => '/assets/img/inner-page/news/news-sm-01.jpg',
                'image3'     => '/assets/img/inner-page/news/news-sm-02.jpg',
                'conclusion' => 'La coopérative prévoit d\'intégrer de nouveaux membres d\'ici 2027, portant son effectif à 50 producteurs, et d\'étendre ses zones de collecte à de nouvelles localités de la Région des Plateaux.',
            ],
            [
                'slug'       => 'riziculture-togo-avenir',
                'title'      => 'La riziculture togolaise peut nourrir l\'Afrique de l\'Ouest — voici comment',
                'category'   => 'Agriculture',
                'tag'        => ['Riziculture', 'TOGO', 'Afrique de l\'Ouest', 'Alimentation'],
                'author'     => 'Équipe HEZOUWE',
                'date'       => '2026-02-20',
                'read'       => '7 min',
                'comments'   => 12,
                'image'      => '/assets/img/inner-page/news/news-01.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-01.jpg',
                'excerpt'    => 'Le TOGO dispose d\'un potentiel rizicole immense encore sous-exploité. HEZOUWE analyse les opportunités et les défis pour faire du riz togolais un acteur majeur de la sécurité alimentaire régionale.',
                'intro'      => 'Le riz est l\'aliment de base de plus de 500 millions de personnes en Afrique de l\'Ouest. Pourtant, la région importe chaque année des millions de tonnes de riz asiatique, alors qu\'elle dispose de terres et de savoir-faire pour produire localement.',
                'body'       => [
                    'Selon les experts agricoles, le TOGO ne valorise que 30% de son potentiel rizicole. Les régions des Plateaux, de la Kara et des Savanes offrent des conditions agro-climatiques idéales pour la riziculture irriguée et pluviale.',
                    'Les principaux obstacles restent l\'accès aux intrants de qualité, la mécanisation insuffisante et les difficultés de commercialisation. C\'est précisément pour répondre à ces défis que des coopératives comme HEZOUWE jouent un rôle crucial.',
                    'Des initiatives récentes, soutenues par des organisations internationales comme Compassion Internationale, ont permis d\'améliorer les rendements dans plusieurs zones de production.',
                ],
                'quote'      => 'Si le TOGO valorise pleinement son potentiel rizicole, il pourrait non seulement atteindre l\'autosuffisance mais aussi devenir un exportateur net vers les pays voisins.',
                'image2'     => '/assets/img/inner-page/news/news-02.jpg',
                'image3'     => '/assets/img/inner-page/news/news-03.jpg',
                'conclusion' => 'HEZOUWE s\'engage à être un acteur de ce changement, en démontrant par l\'exemple que le riz local togolais peut être compétitif, de haute qualité et économiquement viable pour tous les acteurs de la filière.',
            ],
            [
                'slug'       => 'nouveau-centre-conditionnement',
                'title'      => 'HEZOUWE investit dans un nouveau centre de conditionnement à Tagbega',
                'category'   => 'Infrastructure',
                'tag'        => ['Investissement', 'Conditionnement', 'Tagbega', 'Développement'],
                'author'     => 'Direction Générale',
                'date'       => '2026-02-05',
                'read'       => '4 min',
                'comments'   => 6,
                'image'      => '/assets/img/inner-page/news/news-02.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-02.jpg',
                'excerpt'    => 'La coopérative HEZOUWE inaugure son nouveau centre de conditionnement doté d\'équipements modernes, permettant de tripler sa capacité de production et d\'améliorer la qualité de l\'emballage.',
                'intro'      => 'Après plusieurs mois de travaux et d\'installation d\'équipements, COOP CA HEZOUWE inaugure son nouveau centre de conditionnement à Tagbega. Cette infrastructure représente un investissement majeur pour la coopérative et marque une nouvelle étape dans son développement.',
                'body'       => [
                    'Le nouveau centre dispose d\'une ligne automatisée de pesage et d\'ensachage capable de conditionner jusqu\'à 5 tonnes de riz par jour.',
                    'L\'investissement comprend également un système de contrôle qualité automatisé qui détecte les corps étrangers, les grains défectueux et les variations de poids. Ce système réduit les pertes post-conditionnement de 80%.',
                    'Le financement de ce projet a été rendu possible grâce à un prêt de la BTCI, au soutien de Compassion Internationale et à l\'apport en capital des membres de la coopérative.',
                ],
                'quote'      => 'Ce nouveau centre de conditionnement, c\'est notre réponse aux attentes de nos clients. Ils méritent un produit présenté avec soin, digne de la qualité du riz que nos producteurs cultivent.',
                'image2'     => '/assets/img/inner-page/news/news-sm-01.jpg',
                'image3'     => '/assets/img/inner-page/news/news-sm-03.jpg',
                'conclusion' => 'Avec ce nouveau centre, HEZOUWE peut désormais répondre à des commandes institutionnelles importantes et envisage la livraison de ses produits dans les grandes surfaces de Lomé dès le second semestre 2026.',
            ],
            [
                'slug'       => 'partenariat-compassion-internationale',
                'title'      => 'Partenariat HEZOUWE × Compassion Internationale : soutenir les familles rurales',
                'category'   => 'Partenariat',
                'tag'        => ['Compassion Internationale', 'Partenariat', 'Rural', 'Développement'],
                'author'     => 'Relations Extérieures',
                'date'       => '2026-01-18',
                'read'       => '5 min',
                'comments'   => 4,
                'image'      => '/assets/img/inner-page/news/news-03.jpg',
                'thumb'      => '/assets/img/inner-page/news/news-sm-03.jpg',
                'excerpt'    => 'HEZOUWE et Compassion Internationale renouvellent et renforcent leur partenariat visant à améliorer les conditions de vie des familles rurales de la région de Tagbega à travers la filière riz.',
                'intro'      => 'Le partenariat entre COOP CA HEZOUWE et Compassion Internationale représente un modèle innovant de développement rural. En combinant l\'expertise technique de la coopérative et les ressources de l\'ONG internationale, ce partenariat crée un impact durable sur les communautés de la Région des Plateaux.',
                'body'       => [
                    'Compassion Internationale soutient HEZOUWE depuis sa création, notamment à travers le financement d\'équipements de transformation, la formation des producteurs et le renforcement des capacités de gestion de la coopérative.',
                    'Dans le cadre du renouvellement de ce partenariat, plusieurs nouvelles initiatives sont prévues : un programme de formation pour les femmes productrices, un fonds d\'urgence pour les producteurs en cas de mauvaise récolte, et un appui à la digitalisation.',
                    'Au-delà de l\'impact économique, Compassion Internationale soutient également des programmes d\'éducation pour les enfants des familles membres de la coopérative.',
                ],
                'quote'      => 'HEZOUWE et Compassion Internationale partagent la même vision : des familles rurales épanouies, des communautés fortes et une agriculture durable au service de tous.',
                'image2'     => '/assets/img/inner-page/news/news-sm-02.jpg',
                'image3'     => '/assets/img/inner-page/news/news-01.jpg',
                'conclusion' => 'Ce partenariat renouvelé s\'inscrit dans une vision à long terme de développement rural intégré. HEZOUWE et Compassion Internationale s\'engagent conjointement pour les 3 prochaines années.',
            ],
        ];

        foreach ($newsList as $data) {
            News::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title'      => $data['title'],
                    'category'   => $data['category'],
                    'tag'        => $data['tag'] ?? [],
                    'author'     => $data['author'],
                    'date'       => $data['date'],
                    'read'       => $data['read'] ?? '1 min',
                    'comments'   => $data['comments'] ?? 0,
                    'excerpt'    => $data['excerpt'],
                    'intro'      => $data['intro'],
                    'body'       => $data['body'] ?? [],
                    'quote'      => $data['quote'] ?? null,
                    'conclusion' => $data['conclusion'] ?? null,
                    'image'      => $data['image'],
                    'thumb'      => $data['thumb'] ?? null,
                    'image2'     => $data['image2'] ?? null,
                    'image3'     => $data['image3'] ?? null,
                ]
            );
        }

        $this->command->info('  ' . count($newsList) . ' articles seedés.');
    }
}
