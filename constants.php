<?php
define('VERSION', '3.0-SNAPSHOT');
define('DEFAULT_LOCALE', 'fr_FR');
define('PUZZLE_COUNT', 10);

// Field lengths
define('NAME_MIN_LENGTH', 2);
define('NAME_MAX_LENGTH', 24);
define('PSEUDO_MIN_LENGTH', 3);
define('PSEUDO_MAX_LENGTH', 24);
define('USERNAME_MIN_LENGTH', 3);
define('USERNAME_MAX_LENGTH', 16);
define('PASSWORD_MIN_LENGTH', 7);
define('PASSWORD_MAX_LENGTH', 32);
define('GROUP_MIN_LENGTH', 1);
define('GROUP_MAX_LENGTH', 32);

// Patterns (PHP et HTML)
define('PHPPATTERN_NAME', "/^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$/u");
define('HTMLPATTERN_NAME', "^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$");

define('PHPPATTERN_USERNAME', "/^[a-z][a-z0-9]*([.\-][a-z0-9]+)*$/");
define('HTMLPATTERN_USERNAME', "^[a-z][a-z0-9]*([.\-][a-z0-9]+)*$");

define('PHPPATTERN_PSEUDO', "/^(?![\-' .])(?!.*[\-'.]{3})(?!.* {2})(?!.*\.\.)(?!.*[\-']$)[A-Za-zÀ-ÖØ-öø-ÿ' .\-]+[.]?$/u");
define('HTMLPATTERN_PSEUDO', "^(?![\-' .])(?!.*[\-'.]{3})(?!.* {2})(?!.*\.\.)(?!.*[\-']$)[A-Za-zÀ-ÖØ-öø-ÿ' .\-]+[.]?$");

define('PHPPATTERN_GROUP', "/^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$/u");
define('HTMLPATTERN_GROUP', "^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$");

// Durations (in seconds)
define('GAMESESSION_DURATION', 10800); // 3 hours
define('AUTHCOOKIE_DURATION', 604800); // 1 week

// Cookies
define('AUTHCOOKIE_NAME', 'LOGGED_IN');
define('COOKIE7', array(
  'name' => 'cookie_enigme_7',
  'value' => 'Cookie_to_delete_to_solve_puzzle_7._PLEASE_NOTE_THAT_DELETING_ALL_COOKIES_RESETS_YOUR_PROGRESS.'
));
define('COOKIE8', array(
  'name' => 'cookie_enigme_8',
  'value' => str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT) . '404'
));
define('COOKIECHOCOLAT', array(
  'name' => 'cookie_au_chocolat',
  'value' => 'According_to_Wikipedia._A_cookie_or_chocolate_chip_cookie_is_a_small_round_traditional_biscuit_from_American_cuisine_with_chocolate_chips_or_chunks.'
));
define('COOKIECHOCOLATINE', array(
  'name' => 'cookie_chocolatine',
  'value' => 'The_chocolatine_cookie_is_strictly_identical_to_the_chocolate_chip_cookie_but_with_a_strange_name._Very_popular_in_the_southwest_of_France._It_is_unknown_to_Parisians.'
));
define('COOKIEHAZLENUT', array(
  'name' => 'cookie_noisette',
  'value' => 'Our_favorite'
));
define('COOKIESESSION', array(
  'name' => 'cookie_session',
  'value' => 'According_to_Wikipedia._Cookies_allow_websites_to_identify_internet_users_as_they_move_from_one_web_page_to_another_on_the_site_even_when_they_return_years_later._Cookies_are_commonly_used_to_identify_a_user_session_while_they_are_logged_into_their_computer_account.'
));
define('COOKIEPUBLICITAIRE', array(
  'name' => 'cookie_publicitaire',
  'value' => 'According_to_Wikipedia._The_use_of_cookies_by_web_tracking_companies_provokes_hostility._Indeed_these_third-party_cookies_linked_to_online_advertising_banners_allow_tracking_of_internet_users_visiting_websites_that_have_no_relation_except_for_the_tracking_subcontracting_company.'
));
define('COOKIEGOOGLE', array(
  'name' => 'cookie_google',
  'value' => 'Google._With_Google_Android_Chrome_etc._tracks_you_on_the_web._Cookies_are_used_for_this_tracking._But_this_company_has_many_other_methods_to_track_you...'
));
define('COOKIEFACEBOOK', array(
  'name' => 'cookie_facebook',
  'value' => 'Facebook._With_Facebook_Instagram_WhatsApp_etc._tracks_you_on_the_web._Cookies_are_used_for_this_tracking._But_this_company_has_many_other_methods_to_track_you...'
));
define('COOKIEAMAZON', array(
  'name' => 'cookie_amazon',
  'value' => 'Amazon_Advertising._Amazon_offers_advertising_opportunities_for_sellers_and_advertisers_on_its_e-commerce_platform._And_for_this_Amazon_tracks_you_on_the_web_with_cookies.'
));