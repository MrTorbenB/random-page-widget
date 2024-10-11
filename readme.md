
# Random Page Widget

**Version:** 1.0  
**Autor:** Dein Name  
**Beschreibung:** Dieses Plugin zeigt eine zufällige Seite mit einer Vorschau, einem Textauszug und einem Bild an. Du kannst es entweder per Shortcode verwenden oder als Widget zu deiner Sidebar hinzufügen.

## Funktionen

- Zeigt eine zufällige Seite aus deinem WordPress an.
- Gibt den Titel der Seite, einen Textauszug und das vorgestellte Bild (falls vorhanden) aus.
- Enthält einen Shortcode zur Verwendung in Seiten und Beiträgen.
- Wird als Widget unterstützt, um es einfach in der Sidebar oder anderen Widget-Bereichen anzuzeigen.

## Installation

1. Lade den Ordner `random-page-widget` in dein WordPress-Verzeichnis unter `/wp-content/plugins/` hoch.
2. Gehe zu **Plugins** in deinem WordPress-Adminbereich.
3. Aktiviere das Plugin „Random Page Widget“.

## Verwendung

### Shortcode

Du kannst den Shortcode `[random_page]` verwenden, um eine zufällige Seite anzuzeigen. Füge den Shortcode einfach in den Inhalt einer Seite oder eines Beitrags ein.

Beispiel:

\`\`\`text
[random_page]
\`\`\`

Das Plugin zeigt den Titel der zufälligen Seite, das vorgestellte Bild (falls vorhanden), einen Textauszug sowie einen Link zur Seite an.

### Widget

1. Gehe zu **Design > Widgets** in deinem WordPress-Adminbereich.
2. Ziehe das Widget „Random Page Widget“ in den gewünschten Widget-Bereich (z. B. Sidebar).
3. Du kannst das Widget anpassen, falls du später zusätzliche Einstellungen implementierst.

## Anpassungen

Falls du das Layout der angezeigten Seitenvorschau ändern möchtest, kannst du den HTML-Ausgabe-Code in der Plugin-Datei `random-page-widget.php` anpassen. Du kannst z.B. die Bildgröße oder die Formatierung des Textauszugs verändern.

### Beispiel für Änderungen

Wenn du eine andere Bildgröße verwenden möchtest, kannst du die Funktion `get_the_post_thumbnail()` im Plugin-Code anpassen:

\`\`\`php
get_the_post_thumbnail(get_the_ID(), 'large');
\`\`\`

Du kannst auch die Länge des Textauszugs ändern, indem du die Funktion `get_the_excerpt()` durch `wp_trim_words()` ersetzt:

\`\`\`php
wp_trim_words(get_the_content(), 40, '...');
\`\`\`

## Weitere Informationen

- Dieses Plugin verwendet die WordPress-Funktionen `WP_Query` zur Auswahl einer zufälligen Seite und `get_the_post_thumbnail()` zur Anzeige des vorgestellten Bildes.
- Die Widget- und Shortcode-Ausgabe erfolgt in einfacher HTML-Form, damit du es leicht an dein Theme anpassen kannst.
