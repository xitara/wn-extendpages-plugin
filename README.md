# ExtendPages Plugin
**Read english version below!**

## Deutsche README

Dieses Plugin erweitert das Static-Pages Plugin um eine Vorspann-Funktion

### Aktivieren
folgenden Code in ein Layout einfügen:
```
<div class="intro">
    {% placeholder intro title='Vorspann' %}
</div>
```
Der Text `Vorspann` wird im Backend als Tab-Überschrift angezeigt und kann beliebig verändert werden.
Wenn der Vorspanntext nicht direkt auf der Seite erscheinen soll, kann per CSS die Klasse `intro` (dieser Name kann ebenfalls beliebig gewählt werden) auf `display:none` gesetzt werden.

Um eine Übersicht der Intros anzuzeigen, wird ein Menü im Plugin `RainLab.Pages` angelegt und die gewünschten Seiten eingepflegt. Anschliessend werden die Componenten `staticMenu` und `displayIntro` in die gewünschte Seite eingebunden und konfiguriert.

Für die Konfiguration sind zwei Werte erforderlich:
* Menü -> Das gewünschte Menü, das weiter oben angelegt wurde
* Max. Zeichen -> maximale Anzahl der Zeichen des Inhaltes, die angezeigt werden.

---

## English README
This plugin extends static pages with an index with a list-component

**Comming soon**
