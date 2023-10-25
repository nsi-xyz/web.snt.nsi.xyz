<?php
/**
 * La fonction récupère un message à afficher à l'utilisateur lorsqu'il valide l'entrée
 * d'un mot mystère et que ce dernier est correct.
 * 
 * @return string Le message à afficher.
 */
function getOkMessage() {
    $well_done_comments = array("Bravo, cette énigme a été résolue avec brio !","Félicitations, vous avez parfaitement résolu cette énigme !","Impressionnant ! Cette énigme est désormais derrière vous !","Superbe travail ! Cette énigme est maintenant un souvenir !","Vous avez maîtrisé cette énigme avec succès !","Continuez sur cette lancée ! Cette énigme est terminée !","Vous êtes un pro du web ! Cette énigme ne vous résiste pas !","Votre connaissance est impressionnante ! Cette énigme est résolue !","Je suis épaté par vos compétences ! Cette énigme n'était rien pour vous !","Vous êtes un génie du code ! Cette énigme est maintenant un acquis !");
    $support_comments = array("Maintenant, passez à la suivante !","Continuez à explorer les énigmes suivantes !","Ne vous arrêtez pas ici, il y a encore beaucoup à découvrir !","Vous avez du talent, poursuivez sur cette lancée !","L'aventure continue, cherchez la prochaine énigme !","N'arrêtez pas maintenant, de nouvelles énigmes vous attendent !");
    $well_done_comment = $well_done_comments[array_rand($well_done_comments)];
    $support_comment = $support_comments[array_rand($support_comments)];
    return $well_done_comment." ".$support_comment;
}

/**
 * La fonction récupère un message à afficher à l'utilisateur lorsqu'il valide l'entrée
 * d'un mot mystère et que ce dernier est faux.
 * 
 * @return string Le message à afficher.
 */
function getKoMessage() {
    $retry_comments = array("Ce n'est pas la réponse correcte, mais ne baissez pas les bras. La persévérance vous mènera à la solution !","Vous êtes sur la bonne voie, mais il y a encore un peu de travail à faire. Continuez à chercher la réponse !","La solution n'est pas encore tout à fait là, mais avec un peu plus d'effort, vous y parviendrez !","Ce n'est pas la bonne réponse, mais chaque tentative est une opportunité d'apprendre et de progresser.","Pas encore, mais ne perdez pas espoir. La satisfaction de la réussite sera d'autant plus grande !","Vous vous rapprochez, mais il manque encore un élément crucial. Continuez à réfléchir et à explorer !","Ce n'est pas la réponse, mais cela ne signifie pas que vous ne pouvez pas la trouver. Restez concentré et persévérez !","Vous avez fait un effort louable, mais il reste un peu de travail. Ne renoncez pas !","Ce n'est pas la réponse attendue, mais c'est un pas vers l'avant. Continuez à progresser !","Le chemin vers la solution peut sembler difficile, mais cela en vaut la peine. Vous êtes sur la bonne voie !");
    $change_puzzle_comments = array("Si vous ne trouvez pas la réponse, envisagez de passer à une autre énigme pour changer de perspective.","L'univers des énigmes est vaste. Peut-être qu'une autre vous conviendra mieux ?","Si vous êtes bloqué, n'hésitez pas à essayer une autre énigme. Chaque énigme est une opportunité d'apprentissage !","Si cette énigme vous résiste, ne restez pas bloqué. Explorez d'autres énigmes pour continuer à apprendre !","La diversité des énigmes vous offre de nombreuses options. Pourquoi ne pas en essayer une différente ?","Changer d'énigme peut apporter de la fraîcheur à votre réflexion. Passez à une autre pour de nouvelles perspectives !","Si cette énigme semble trop difficile, ne soyez pas découragé. Essayez-en une autre et revenez plus tard !");
    $retry_comment = $retry_comments[array_rand($retry_comments)];
    $change_puzzle_comment = $change_puzzle_comments[array_rand($change_puzzle_comments)];
    return $retry_comment." ".$change_puzzle_comment;
}

// Liste de noms d'informaticiens pour les énigmes 1 et 2.
function getMysteryComputerScientist() {
    $maleComputerScientists = array("Alan Turing", "Linus Torvalds", "John von Neumann", "Donald Knuth", "Tim Berners-Lee", "Larry Page", "Sergey Brin", "John McCarthy", "Vint Cerf", "Ken Thompson", "Alan Kay", "Donna Strickland", "Shafi Goldwasser", "Brenda Milner", "Raj Reddy", "Leslie Lamport", "Susan Eggers");
    $femaleComputerScientists = array("Ada Lovelace", "Grace Hopper", "Margaret Hamilton", "Ada Yonath", "Barbara Liskov", "Frances E. Allen", "Ruchi Sanghvi", "Radia Perlman", "Adele Goldberg", "Karen Sparck Jones", "Vera Rubin", "Cynthia Breazeal", "Dorothy Crowfoot Hodgkin", "Marian Croak", "Wendy Hall", "Jude Milhon", "Rosalind Picard");
    $randomMale = $maleComputerScientists[array_rand($maleComputerScientists)];
    $randomFemale = $femaleComputerScientists[array_rand($femaleComputerScientists)];
    $flip = mt_rand(0, 1);
    if ($flip === 0) {
        return $randomMale;
    } else {
        return $randomFemale;
    }
}


// Liste d'attributs CSS utilisée pour les énigmes 3 et 4.
function getMysteryAttribute() {
    $attributes = array("color", "font-size", "background-color", "border", "margin", "padding", "text-align", "width", "height", "display", "position", "top", "left", "right", "bottom", "font-family", "line-height", "letter-spacing", "text-transform", "text-decoration", "text-shadow", "box-shadow", "box-sizing", "cursor", "z-index", "border-radius", "opacity", "transform", "transition", "border-collapse", "text-overflow", "white-space", "overflow", "float", "clear", "list-style", "word-wrap", "box-sizing", "vertical-align", "user-select", "position", "font-weight", "outline", "flex", "visibility", "content", "quotes", "counter-increment", "counter-reset", "flex-direction", "flex-wrap", "justify-content", "align-items", "align-content", "order", "flex-grow", "flex-shrink", "flex-basis", "align-self");
    return $attributes[array_rand($attributes)];
}

function getMysteryLinux() {
    $distributions = array("debian", "ubuntu", "fedora", "centos", "arch", "mint", "redhat",  "gentoo", "suse");
    return $distributions[array_rand($distributions)];
}

// Liste de balises couleurs utilisée pour l'énigme 10.
function getMysteryColor() {
    $colors = array("#00FA9A" => "MediumSpringGreen","#20B2AA" => "LightSeaGreen","#00FFFF" => "Aqua","#1E90FF" => "DodgerBlue","#00FF7F" => "SpringGreen","#3CB371" => "MediumSeaGreen","#32CD32" => "LimeGreen","#66CDAA" => "MediumAquaMarine","#48D1CC" => "MediumTurquoise","#90EE90" => "LightGreen","#98FB98" => "PaleGreen","#00FF00" => "Lime","#7FFF00" => "Chartreuse","#7FFFD4" => "Aquamarine","#40E0D0" => "Turquoise","#87CEEB" => "SkyBlue","#87CEFA" => "LightSkyBlue","#00BFFF" => "DeepSkyBlue","#6495ED" => "CornflowerBlue","#4682B4" => "SteelBlue","#4169E1" => "RoyalBlue","#1E90FF" => "DodgerBlue","#6A5ACD" => "SlateBlue","#483D8B" => "DarkSlateBlue","#4B0082" => "Indigo","#8A2BE2" => "BlueViolet","#9932CC" => "DarkOrchid","#9400D3" => "DarkViolet","#8B0000" => "DarkRed","#DC143C" => "Crimson","#FF4500" => "OrangeRed","#FF6347" => "Tomato","#FF7F50" => "Coral","#FFA07A" => "LightSalmon","#FA8072" => "Salmon","#E9967A" => "DarkSalmon","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#CD853F" => "Peru","#DEB887" => "BurlyWood","#D2B48C" => "Tan","#FFF5EE" => "SeaShell","#FAEBD7" => "AntiqueWhite","#FAF0E6" => "Linen","#FFE4C4" => "Bisque","#FFDAB9" => "PeachPuff","#FFE4B5" => "Moccasin","#FFE4E1" => "MistyRose","#FAFAD2" => "LightGoldenrodYellow","#FFFFE0" => "LightYellow","#F0E68C" => "Khaki","#FFD700" => "Gold","#FFA500" => "Orange","#DAA520" => "Goldenrod","#CD853F" => "Peru","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#CD853F" => "Peru","#D2691E" => "Chocolate","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#CD853F" => "Peru","#D2691E" => "Chocolate","#A52A2A" => "Brown","#8B0000" => "DarkRed","#B22222" => "FireBrick","#A52A2A" => "Brown","#800000" => "Maroon","#8B0000" => "DarkRed","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#CD853F" => "Peru","#D2691E" => "Chocolate","#8B4513" => "SaddleBrown","#A0522D" => "Sienna");
    $key = array_rand($colors);
    $value = $colors[$key];
    return array('hex' => $key, 'name' => $value);
}
?>