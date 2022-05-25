<?php
return [
    'displayintro'  => [
        'name'        => 'Seiten-Intros anzeigen',
        'description' => 'Zeigt Intros von Seiten die einen Platzhalter "intro" besitzen und in einem Menü konfiguriert sind',
    ],
    'code'          => [
        'title'       => 'Menü',
        'description' => 'Menü, dessen Seiten in der Liste angezeigt werden',
    ],
    'maxchars'      => [
        'title'             => 'Max. Zeichen',
        'description'       => 'Maximale Anzahl von Zeichen die vom Text angezeigt werden. Bei 0 (null) ist die Zeichenanzahl unbegrenzt',
        'validationMessage' => 'Es sind nur Zahlen erlaubt',
    ],
    'isHeading'     => [
        'title'       => 'Überschrift anzeigen',
        'description' => 'Zeigt den Namen des Menüs als Überschrift (h2) an',
    ],
    'isSubHeading'  => [
        'title'       => 'Unterüberschrift anzeigen',
        'description' => 'Zeigt den Seitennamen als Überschrift (h3) über dem Seitenintro an',
    ],
    'moreLinkTitle' => [
        'title'       => 'Text des Detail-Links',
        'description' => 'Definiert den Text des Links zu der Seite selbst. Beispiel: "mehr Infos". Wenn hier nichts angegeben wurde, wird der Seitentitel als text verwendet',
    ],
    ''              => [
        'title'       => '',
        'description' => '',
    ],
];
