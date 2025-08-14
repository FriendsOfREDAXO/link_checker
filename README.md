# Link Checker für REDAXO

Dieses Addon prüft in regelmäßigen Abständen, welche Hyperlinks auf der REDAXO-Seite in Anker-Tags verwendet werden und ob diese noch gültig / erreichbar sind, oder verwaist / fehlerhaft sind.

> **Hinweis:** Dieses Addon ist derzeit noch in der Entwicklung. Die weitere Entwicklung benötigt jedoch finanzielle Förderung. Wenn du dieses Addon hilfreich findest, beteilige dich an der Entwicklung - entweder finanziell oder mit der Umsetzung von Features.

## Features

Aktuell wird beim Installieren des Addons die `sitemap.xml` aller in YRewrite eingetragenen Domains durchsucht. Anschließend wird, solange man im Backend eingeloggt ist, regelmäßig ein API-Call an deine Website `www.example.org/?rex-api-call=link_checker` ausgeführt und dabei einer der bisher ungeprüften oder zuletzt geprüften Links aufgerufen.

![www redaxo local_redaxo_index php_page=link_checker_link_checker_links](https://user-images.githubusercontent.com/3855487/210610756-bebba194-3fb1-4d3c-b0f8-d0e67791efd1.png)

### `?rex-api-call=link_checker`

Prüft automatisch den nächsten ungeprüften Link bzw. einen Link, der schon lange nicht mehr geprüft wurde.

### `?rex-api-call=link_checker&url=https://www.example.org/foo`

Nimmt die Seite `https://www.example.org/foo` in den Index der zu prüfenden Seiten auf.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/FriendsOfREDAXO/link_checker/blob/master/LICENSE.md)  

## Autoren

**Friends Of REDAXO**
<http://www.redaxo.org>
<https://github.com/FriendsOfREDAXO>

**Projekt-Lead**  
[Alexander Walther](https://github.com/alxndr-w)

## Credits

Erste Version von...

**Alexander Walther**  
<https://github.com/alexplusde>
