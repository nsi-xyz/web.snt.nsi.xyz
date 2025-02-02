<?php
/**
 * La fonction récupère un message à afficher à l'utilisateur lorsqu'il valide l'entrée
 * d'un mot mystère et que ce dernier est correct.
 * 
 * @return string Le message à afficher.
 */
function getOkMessage() {
    $well_done_comments = array(traduction("puzzle_message_ok1"), traduction("puzzle_message_ok2"), traduction("puzzle_message_ok3"), traduction("puzzle_message_ok4"), traduction("puzzle_message_ok5"), traduction("puzzle_message_ok6"), traduction("puzzle_message_ok7"), traduction("puzzle_message_ok8"), traduction("puzzle_message_ok9"));
    $support_comments = array(traduction("puzzle_message_support1"), traduction("puzzle_message_support2"), traduction("puzzle_message_support3"), traduction("puzzle_message_support4"), traduction("puzzle_message_support5"), traduction("puzzle_message_support6"));
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
    $retry_comments = array(traduction("puzzle_message_ko1"), traduction("puzzle_message_ko2"), traduction("puzzle_message_ko3"), traduction("puzzle_message_ko4"), traduction("puzzle_message_ko5"), traduction("puzzle_message_ko6"), traduction("puzzle_message_ko7"), traduction("puzzle_message_ko8"), traduction("puzzle_message_ko9"));
    $change_puzzle_comments = array(traduction("puzzle_message_change1"), traduction("puzzle_message_change2"), traduction("puzzle_message_change3"), traduction("puzzle_message_change4"), traduction("puzzle_message_change5"), traduction("puzzle_message_change6"));
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

function getMysteryLinux() {
    $distributions = array("debian", "ubuntu", "fedora", "centos", "arch", "mint", "redhat",  "gentoo", "suse");
    return $distributions[array_rand($distributions)];
}

// Liste de balises couleurs utilisée pour l'énigme 10.
function getMysteryColor() {
    $colors = array("#00FA9A" => "MediumSpringGreen","#20B2AA" => "LightSeaGreen","#00FFFF" => "Aqua","#1E90FF" => "DodgerBlue","#00FF7F" => "SpringGreen","#3CB371" => "MediumSeaGreen","#32CD32" => "LimeGreen","#66CDAA" => "MediumAquaMarine","#48D1CC" => "MediumTurquoise","#90EE90" => "LightGreen","#98FB98" => "PaleGreen","#00FF00" => "Lime","#7FFF00" => "Chartreuse","#7FFFD4" => "Aquamarine","#40E0D0" => "Turquoise","#87CEEB" => "SkyBlue","#87CEFA" => "LightSkyBlue","#00BFFF" => "DeepSkyBlue","#6495ED" => "CornflowerBlue","#4682B4" => "SteelBlue","#4169E1" => "RoyalBlue","#6A5ACD" => "SlateBlue","#483D8B" => "DarkSlateBlue","#4B0082" => "Indigo","#8A2BE2" => "BlueViolet","#9932CC" => "DarkOrchid","#9400D3" => "DarkViolet","#8B0000" => "DarkRed","#DC143C" => "Crimson","#FF4500" => "OrangeRed","#FF6347" => "Tomato","#FF7F50" => "Coral","#FFA07A" => "LightSalmon","#FA8072" => "Salmon","#E9967A" => "DarkSalmon","#CD5C5C" => "IndianRed","#8B4513" => "SaddleBrown","#A0522D" => "Sienna","#D2691E" => "Chocolate","#B22222" => "FireBrick","#A52A2A" => "Brown","#CD853F" => "Peru","#DEB887" => "BurlyWood","#D2B48C" => "Tan","#FFF5EE" => "SeaShell","#FAEBD7" => "AntiqueWhite","#FAF0E6" => "Linen","#FFE4C4" => "Bisque","#FFDAB9" => "PeachPuff","#FFE4B5" => "Moccasin","#FFE4E1" => "MistyRose","#FAFAD2" => "LightGoldenrodYellow","#FFFFE0" => "LightYellow","#F0E68C" => "Khaki","#FFD700" => "Gold","#FFA500" => "Orange","#DAA520" => "Goldenrod","#800000" => "Maroon");
    $key = array_rand($colors);
    $value = $colors[$key];
    return array('hex' => $key, 'name' => $value);
}