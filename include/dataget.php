<?php
/**
 * La fonction récupère un message amusant à afficher à l'utilisateur lorsqu'il tente de rentrer un mot mystère.
 * 
 * @param type Le paramètre type est un paramètre indiquant quel type de message affiché.
 * Il existe deux types de message, les messages lorsque la réponse est juste (1), et les
 * messages lorsque la réponse est fausse (0).
 * 
 * @return string Le message à afficher.
 */
function getFunnyMessage($type) {
    $correct_anwsers = array();
    $wrong_anwsers = array();
    return $type == 1 ? $correct_anwsers[array_rand($correct_anwsers)] : $wrong_anwsers[array_rand($wrong_anwsers)];
};

// Liste de balises HTML utilisée pour les énigmes 1 et 2.
function getMysteryTag() {
    $tags = array("span", "body", "div", "p", "h1", "h2", "h3", "a", "img", "ul", "li", "ol", "table", "tr", "td", "th", "form", "input", "button", "textarea", "section", "header", "footer", "nav", "article", "aside", "main", "figure", "figcaption", "em", "strong", "i", "b", "u", "strike", "mark", "code", "pre");
    return $tags[array_rand($tags)];
};

// Liste de balises couleurs utilisée pour l'énigme 10.
function getMysteryColor() {
    $colors = array("#00FA9A" => "MediumSpringGreen","#20B2AA" => "LightSeaGreen","#00FFFF" => "Aqua","#1E90FF" => "DodgerBlue","#00FF7F" => "SpringGreen","#3CB371" => "MediumSeaGreen","#32CD32" => "LimeGreen","#66CDAA" => "MediumAquaMarine","#48D1CC" => "MediumTurquoise","#90EE90" => "LightGreen","#98FB98" => "PaleGreen","#00FF00" => "Lime","#7FFF00" => "Chartreuse","#7FFFD4" => "Aquamarine","#40E0D0" => "Turquoise","#87CEEB" => "SkyBlue","#87CEFA" => "LightSkyBlue","#00BFFF" => "DeepSkyBlue","#6495ED" => "CornflowerBlue","#4682B4" => "SteelBlue","#4169E1" => "RoyalBlue","#1E90FF" => "DodgerBlue","#6A5ACD" => "SlateBlue","#483D8B" => "DarkSlateBlue","#4B0082" => "Indigo","#8A2BE2" => "BlueViolet","#9932CC" => "DarkOrchid","#9400D3" => "DarkViolet","#8B0000" => "DarkRed","#DC143C" => "Crimson","#FF4500" => "OrangeRed","#FF6347" => "Tomato","#FF7F50" => "Coral","#FFA07A" => "LightSalmon","#FA8072" => "Salmon","#E9967A" => "DarkSalmon","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#CD853F" => "Peru","#DEB887" => "BurlyWood","#D2B48C" => "Tan","#FFF5EE" => "SeaShell","#FAEBD7" => "AntiqueWhite","#FAF0E6" => "Linen","#FFE4C4" => "Bisque","#FFDAB9" => "PeachPuff","#FFE4B5" => "Moccasin","#FFE4E1" => "MistyRose","#FAFAD2" => "LightGoldenrodYellow","#FFFFE0" => "LightYellow","#F0E68C" => "Khaki","#FFD700" => "Gold","#FFA500" => "Orange","#DAA520" => "Goldenrod","#CD853F" => "Peru","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#CD853F" => "Peru","#D2691E" => "Chocolate","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#CD853F" => "Peru","#D2691E" => "Chocolate","#A52A2A" => "Brown","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#800000" => "Maroon","#8B0000" => "DarkRed","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#CD853F" => "Peru","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna");
    $key = array_rand($colors);
    $value = $colors[$key];
    return array('hex' => $key, 'name' => $value);
};
?>