command_exists() {
    command -v "$1" >/dev/null 2>&1
}

if ! command_exists git; then
    echo "ERROR: Missing Git!" >&2
    exit 1
fi

if ! command_exists docker; then
    echo "ERROR: Missing Docker!" >&2
    exit 1
fi

if ! command_exists docker-compose; then
    echo "ERROR: Missing Docker Compose!" >&2
    exit 1
fi

if [ ! -e ".executed" ]; then
    rm -rf db_data

    docker compose up --build -d

    ./wait-for-it.sh 127.0.0.1:3306 -t 0

    docker exec -i magazordapi-app-1 php -r "$(cat migration.php)"

    touch .executed
else
    echo "Do not execute init.sh again. If you had any problem on installation process, please reclone the repository."
fi

echo "Pressione Enter para continuar..."
read
