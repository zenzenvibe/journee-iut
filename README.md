# journee-iut

# Configuration du serveur

    sudo apt update
    sudo apt-get install python-minimal
    sudo apt install zip
    sudo apt install docker-compose
    sudo gpasswd -a $USER docker



# Installation initiale

    git clone https://github.com/jossets/journee-iut.git
    cp traefik.toml.ori traefik.toml
    Mettre à  jour les champs en XXXXX

    cp acme.json.default acme.json

    htpasswd -b ./htpasswd user passwd

    docker-compose up



