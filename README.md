# journee-iut

# Configuration du serveur

    sudo apt update
    sudo apt-get install python-minimal
    sudo apt install zip
    sudo apt install docker-compose
    sudo gpasswd -a $USER docker



# Installation initiale

    git clone https://github.com/jossets/journee-iut.git
    cd journee-iut/

    cp traefik.toml.ori traefik.toml
    Mettre à  jour les champs en XXXXX

    cp acme.json.default acme.json
    cp www_site/conf/htpasswd.ori www_site/conf/htpasswd

    htpasswd -b ./htpasswd user passwd

    docker-compose up



