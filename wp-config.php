<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wordpress');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'IG,_6s9*M?UtY[OxJrS)@cDw~AF>?W|)?FxJuj#v|8%:pV0eu.Zi9F0I1n7&gay{');
define('SECURE_AUTH_KEY',  'N&h(^i@H~`27ip`=zLlm!8~+:3>GSQ{AozH*+LdG^k[5au:z ,-suil`pqk(.k|E');
define('LOGGED_IN_KEY',    'QL5Cruu}nKgX_g!rPh(Kw0~~5#}MX.!SE-5`00wT<a;{)5E86KKeFNeyu; 3WeFm');
define('NONCE_KEY',        '%T!^$g^Tjp+xXhz&>+D4mZu9-$8[L|Y-g,piJlenB9Il8m@IXPu+O*ofk?7^31@T');
define('AUTH_SALT',        'IfHM<nMMNHvgNh/nOM{{d>KF#jakwWOsxcY*%J1D-q}a_1_yJR_N>c%7sI!^#qKp');
define('SECURE_AUTH_SALT', '^C$_K6r*wW#[+; {=wZ6=V4@-mrX(x&YZ@it>{KwIYXE(S0NCqtJmx-j&_?!J)=)');
define('LOGGED_IN_SALT',   '*^F2dQa:caqst.1&ef_w>,|8#VzdrpZVP^C%k.1P2_FxYn$ FL&npVdk~EA8${M ');
define('NONCE_SALT',       'QnWALqR3q4OW}VEZh%`~YpqF*:/Ngx,6jptH>ETqB,P9R,/o8:c%h>#!h BW} AU');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d'information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');