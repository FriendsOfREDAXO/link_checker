<?php

# in der uninstall.php sollten Befehle ausgeführt werden, die alle Änderungen, die mit der Installation kamen, entfernen.

# Konfiguration entfernen
# rex_config::removeNamespace("link_checker");

# Installierte Metainfos entfernen
# rex_metainfo_delete_field('art_link_checker');
# rex_metainfo_delete_field('cat_link_checker');
# rex_metainfo_delete_field('med_link_checker');
# rex_metainfo_delete_field('clang_link_checker');

# Zusäzliche Verzeichnisse entfernen, z.B.
# rex_dir::delete(rex_path::get('link_checker'), true);

# YForm-Tabellen löschen (die YForm-Tabellendefinition wird gelöscht, nicht die Datenbank-Tabellen)
# rex_yform_manager_table_api::removeTable('rex_link_checker');

# Weitere Vorgänge
# ...
