# Installation de GINCO

## Prérequis
Installation des machines


## Récupération des codes
```bash
# récupérer le code du projet ginco
git clone https://github.com/SINP-GINCO/ginco.git`
cd ginco
# lire les versions des dépendances nécessaires
cat dependencies.ppts
# ogam : ginco
# configurator : develop

# récupérer le code du configurateur
git clone -b develop https://github.com/SINP-GINCO/ogam-configurator.git configurator

# récupérer le code d'OGAM et le placer dans le répertoire ogam:
# Ce code n'est pas encore disponible en ligne.
# git clone -b ginco https://github.com/ORGANISATION/OGAM.git ogam
```

## Configurer votre instance
Copier le fichier `configs/example.properties` et adapter le contenu à votre instance.

## Initialisation de la base
Le script create_db.php va créer et initialiser la base de votre instance.
```bash
php database/init/create_db.php -f configs/moninstance.properties
```

## Lancer le build
Le script `build_ginco.php` va builder tout ce qu'il faut et tout vous ranger dans
le répertoire `build`
```bash
build_ginco.php -f configs/moninstance.properties
```

## Déployer
FIXME
