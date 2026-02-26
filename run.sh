#!/usr/bin/env bash

# Script de gestion WordPress (Nginx + MariaDB)
# Version optimisée pour de meilleures performances

set -e

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
DOCKER_COMPOSE_FILE="config/docker.yml"
WP_CONFIG_FILE="wp-config.php"
THEME_DIR="wp-content/themes/kezart-lpb"

# Fonction d'affichage coloré
print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}"
    echo "╔══════════════════════════════════════════════════════════════╗"
    echo "║                  🚀 WordPress Manager 🚀                     ║"
    echo "║              Nginx + MariaDB + PHP-FPM-ALPINE                ║"
    echo "╚══════════════════════════════════════════════════════════════╝"
    echo -e "${NC}"
}

# Vérification des prérequis
check_requirements() {
    if ! command -v docker &> /dev/null; then
        print_error "Docker n'est pas installé. Veuillez l'installer d'abord."
        exit 1
    fi

    if ! command -v docker-compose &> /dev/null; then
        print_error "Docker Compose n'est pas installé. Veuillez l'installer d'abord."
        exit 1
    fi
}

# Fonction pour attendre que les services soient prêts
wait_for_services() {
    print_message "⏳ Attente du démarrage..."
    
    # Attendre MariaDB
    print_message "📊 Vérification MariaDB..."
    local timeout=60
    local count=0
    
    while [ $count -lt $timeout ]; do
        if docker exec mariadb sh -c 'mariadb -u wordpress -pwordpress -e "SELECT 1;" 2>/dev/null' &>/dev/null; then
            echo ""
            print_message "✅ MariaDB prêt"
            break
        fi
        printf "."
        sleep 2
        ((count+=2))
    done
    
    if [ $count -ge $timeout ]; then
        echo ""
        print_warning "⚠️  MariaDB prend du temps à démarrer"
        print_message "💡 Vérifiez: docker exec mariadb mariadb -u wordpress -pwordpress"
    fi
    
    # Attendre WordPress/Nginx
    print_message "🌐 Vérification WordPress..."
    timeout=30
    count=0
    
    while [ $count -lt $timeout ]; do
        if curl -f http://localhost:8080 &>/dev/null; then
            echo ""
            print_message "✅ WordPress prêt"
            break
        fi
        printf "."
        sleep 2
        ((count+=2))
    done
    
    if [ $count -ge $timeout ]; then
        echo ""
        print_warning "⚠️  WordPress/Nginx prend du temps"
        print_message "💡 Vérifiez: http://localhost:8080"
    fi
}

# Installation de Composer dans le conteneur WordPress
setup_composer() {
    print_message "🔧 Vérification de Composer..."

    if docker exec wordpress which composer &>/dev/null; then
        print_message "✅ Composer déjà installé"
        return 0
    fi

    print_message "📥 Installation de Composer..."
    if docker exec wordpress sh -c "curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer" &>/dev/null; then
        print_message "✅ Composer installé avec succès"
    else
        print_error "❌ Erreur lors de l'installation de Composer"
        return 1
    fi
}

# Installation des dépendances PHP du thème
install_theme_dependencies() {
    local theme_path="/var/www/html/$THEME_DIR"

    print_message "📦 Vérification des dépendances PHP du thème..."

    # Vérifier si composer.json existe
    if ! docker exec wordpress test -f "$theme_path/composer.json" &>/dev/null; then
        print_message "ℹ️  Pas de composer.json dans le thème"
        return 0
    fi

    # Vérifier si vendor existe déjà
    if docker exec wordpress test -d "$theme_path/vendor" &>/dev/null; then
        print_message "✅ Dépendances PHP déjà installées"
        return 0
    fi

    print_message "📥 Installation des dépendances PHP du thème..."
    if docker exec wordpress sh -c "cd $theme_path && composer install --no-dev --optimize-autoloader --no-interaction" 2>&1 | grep -E "(Installing|Generating|packages you are using)" | head -5; then
        print_message "✅ Dépendances PHP installées"
    else
        print_warning "⚠️  Problème lors de l'installation des dépendances PHP"
        print_message "💡 Vérifiez manuellement: docker exec wordpress sh -c 'cd $theme_path && composer install'"
    fi
}

# Génération du wp-config.php optimisé
generate_wp_config() {
    if [ ! -f "$WP_CONFIG_FILE" ]; then
        print_message "📝 Génération du wp-config.php..."
        cat > "$WP_CONFIG_FILE" << 'EOF'
<?php
// Configuration de base de données
define('DB_NAME', 'wordpress');
define('DB_USER', 'wordpress');
define('DB_PASSWORD', 'wordpress');
define('DB_HOST', 'mariadb');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Clés de sécurité WordPress (à régénérer en production)
define('AUTH_KEY',         'votre-cle-auth-unique');
define('SECURE_AUTH_KEY',  'votre-cle-secure-auth-unique');
define('LOGGED_IN_KEY',    'votre-cle-logged-in-unique');
define('NONCE_KEY',        'votre-cle-nonce-unique');
define('AUTH_SALT',        'votre-salt-auth-unique');
define('SECURE_AUTH_SALT', 'votre-salt-secure-auth-unique');
define('LOGGED_IN_SALT',   'votre-salt-logged-in-unique');
define('NONCE_SALT',       'votre-salt-nonce-unique');

// Préfixe des tables
$table_prefix = 'wp_';

// Mode debug (désactiver en production)
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);

// Optimisations performances
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');
define('WP_CACHE', true);
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);
define('ENFORCE_GZIP', true);

// Sécurité
define('DISALLOW_FILE_EDIT', true);
define('FORCE_SSL_ADMIN', false);

// Configuration des révisions et corbeille
define('WP_POST_REVISIONS', 3);
define('AUTOSAVE_INTERVAL', 300);
define('EMPTY_TRASH_DAYS', 7);

// URLs
define('WP_HOME', 'http://localhost:8080');
define('WP_SITEURL', 'http://localhost:8080');

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
EOF
        print_message "✅ wp-config.php généré avec succès!"
    else
        print_message "ℹ️  wp-config.php existe déjà"
    fi
}

# Import de base de données avec détection automatique et vérification intelligente
import_database() {
    # Vérifier si la base contient déjà des données
    local table_count=$(docker exec mariadb mariadb -u wordpress -pwordpress -e "SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema='wordpress';" wordpress 2>/dev/null | tail -1)
    
    if [[ "$table_count" =~ ^[0-9]+$ ]] && [ "$table_count" -gt 0 ]; then
        print_message "✅ Base existante utilisée"
        return 0
    fi
    
    SQL_FILES=($(find config/ -maxdepth 1 -name "*.sql" 2>/dev/null | head -5))
    
    if [ ${#SQL_FILES[@]} -eq 0 ]; then
        print_warning "Aucun fichier SQL trouvé"
        return 0
    elif [ ${#SQL_FILES[@]} -eq 1 ]; then
        SQL_FILE="${SQL_FILES[0]}"
        print_message "📥 Import automatique: $SQL_FILE"
    else
        print_message "📋 Fichiers SQL disponibles:"
        for i in "${!SQL_FILES[@]}"; do
            echo "   $((i+1)). ${SQL_FILES[i]}"
        done
        echo -n "Choisir (1-${#SQL_FILES[@]}) ou Entrée pour ignorer: "
        read choice
        
        if [[ "$choice" =~ ^[1-9][0-9]*$ ]] && [ "$choice" -le "${#SQL_FILES[@]}" ]; then
            SQL_FILE="${SQL_FILES[$((choice-1))]}"
        else
            print_message "Import ignoré"
            return 0
        fi
    fi
    
    print_message "📥 Import en cours..."
    if docker exec -i mariadb mariadb -u wordpress -pwordpress wordpress < "$SQL_FILE"; then
        print_message "✅ Base importée"
    else
        print_error "❌ Erreur import"
    fi
}

# Démarrage des services
start_services() {
    # Vérifier si c'est la première installation
    local existing_volumes=$(docker volume ls --filter name=config_mariadb_data --format "{{.Name}}" | wc -l | tr -d ' ')
    
    if [ "$existing_volumes" -eq 0 ]; then
        print_warning "⚠️  Première utilisation détectée"
        print_message "🔄 Utilisez l'installation fraîche (option 3)"
        echo ""
        echo -e "${YELLOW}Commande: ./run.sh 3${NC}"
        return 1
    fi
    
    print_message "🚀 Démarrage WordPress..."
    docker-compose -f "$DOCKER_COMPOSE_FILE" up -d
    
    wait_for_services

    print_message "📝 Configuration montée"

    # Vérifier la base de données
    local table_count=$(docker exec mariadb mariadb -u wordpress -pwordpress -e "SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema='wordpress';" wordpress 2>/dev/null | tail -1)

    if [[ "$table_count" =~ ^[0-9]+$ ]] && [ "$table_count" -gt 0 ]; then
        print_message "🔍 Base existante ($table_count tables)"
        print_message "✅ Base prête"
    else
        print_message "📊 Base vide"
    fi

    # Installation de Composer et des dépendances PHP
    setup_composer
    install_theme_dependencies

    print_message "🎉 Démarrage terminé"
    echo ""
    echo -e "${GREEN}🌐 WordPress:${NC} http://localhost:8080"
    echo -e "${GREEN}📊 Base de données:${NC} MariaDB"
    echo ""
    echo ""
    echo -e "${BLUE}🎨 Accéder au thème maintenant?${NC}"
    echo -n "Continuer? (y/N): "
    read theme_choice
    echo ""
    
    if [[ "$theme_choice" == "y" || "$theme_choice" == "Y" ]]; then
        theme_access
    fi
}

# Arrêt des services
stop_services() {
    print_message "🛑 Arrêt..."
    docker-compose -f "$DOCKER_COMPOSE_FILE" down
    print_message "✅ Arrêté"
}

# Installation fraîche
fresh_install() {
    print_warning "⚠️  Installation fraîche - Supprime tout!"
    echo -n "Continuer? (y/N): "
    read confirm
    
    if [[ "$confirm" != "y" && "$confirm" != "Y" ]]; then
        print_message "Installation annulée"
        return 0
    fi
    
    print_message "🧹 Nettoyage..."
    docker-compose -f "$DOCKER_COMPOSE_FILE" down -v
    docker volume prune -f
    
    if [ -f "$WP_CONFIG_FILE" ]; then
        rm "$WP_CONFIG_FILE"
        print_message "🗑️  wp-config.php supprimé"
    fi
    
    generate_wp_config
    
    print_message "🚀 Démarrage WordPress..."
    docker-compose -f "$DOCKER_COMPOSE_FILE" up -d
    
    wait_for_services

    print_message "📝 Configuration montée"

    import_database

    # Installation de Composer et des dépendances PHP
    setup_composer
    install_theme_dependencies

    print_message "🎉 Installation terminée"
    echo ""
    echo -e "${GREEN}🌐 WordPress:${NC} http://localhost:8080"
    echo -e "${GREEN}📊 Base de données:${NC} MariaDB"
    echo ""
    echo ""
    echo -e "${BLUE}🎨 Accéder au thème maintenant?${NC}"
    echo -n "Continuer? (y/N): "
    read theme_choice
    echo ""
    
    if [[ "$theme_choice" == "y" || "$theme_choice" == "Y" ]]; then
        theme_access
    fi
}

# Accès au thème avec gestion NPM
theme_access() {
    if [ ! -d "$THEME_DIR" ]; then
        print_error "Le répertoire du thème '$THEME_DIR' n'existe pas"
        return 1
    fi
    
    cd "$THEME_DIR"
    print_message "📂 Accès au thème: $THEME_DIR"
    
    if [ -f "package.json" ]; then
        echo ""
        echo -e "${BLUE}Actions disponibles:${NC}"
        echo "1. 🔧 npm run dev (Vite)"
        echo "2. 🏗️  npm run build"
        echo "3. 📦 npm install"
        echo "4. 🐚 Ouvrir un shell dans ce répertoire"
        echo ""
        echo -n "Choisir une action (1-4) ou Entrée pour shell: "
        read choice
        
        case $choice in
            1)
                print_message "🚀 Démarrage de Vite en mode développement..."
                npm run d
                ;;
            2)
                print_message "🏗️  Build de production..."
                npm run b
                ;;
            3)
                print_message "📦 Installation des dépendances..."
                npm install
                ;;
            4|"")
                print_message "🐚 Shell ouvert dans le répertoire du thème"
                exec $SHELL
                ;;
            *)
                print_warning "Choix invalide"
                exec $SHELL
                ;;
        esac
    else
        print_warning "Aucun package.json trouvé dans le thème"
        exec $SHELL
    fi
}

# Réinstallation des dépendances PHP
reinstall_php_dependencies() {
    print_message "🔄 Réinstallation des dépendances PHP..."

    # Vérifier que les conteneurs sont démarrés
    if ! docker ps | grep -q wordpress; then
        print_error "WordPress n'est pas démarré. Démarrez-le d'abord (option 1)"
        return 1
    fi

    local theme_path="/var/www/html/$THEME_DIR"

    # Supprimer le dossier vendor existant
    print_message "🗑️  Suppression de l'ancien vendor..."
    docker exec wordpress sh -c "rm -rf $theme_path/vendor $theme_path/composer.lock" 2>/dev/null

    # Réinstaller Composer si nécessaire
    setup_composer

    # Réinstaller les dépendances
    print_message "📥 Réinstallation des dépendances..."
    docker exec wordpress sh -c "cd $theme_path && composer install --no-dev --optimize-autoloader --no-interaction"

    print_message "✅ Dépendances réinstallées"
}

# Changement du mot de passe admin WordPress
change_admin_password() {
    print_message "🔐 Changement du mot de passe admin WordPress..."

    # Vérifier que les conteneurs sont démarrés
    if ! docker ps | grep -q mariadb; then
        print_error "MariaDB n'est pas démarré. Démarrez-le d'abord (option 1)"
        return 1
    fi

    # Demander l'email de l'utilisateur
    echo ""
    echo -n "Email de l'utilisateur admin: "
    read user_email

    if [ -z "$user_email" ]; then
        print_error "Email requis"
        return 1
    fi

    # Vérifier que l'utilisateur existe
    local user_exists=$(docker exec mariadb mariadb -u wordpress -pwordpress wordpress -se "SELECT COUNT(*) FROM wp_users WHERE user_email='$user_email';" 2>/dev/null)

    if [ "$user_exists" -eq 0 ]; then
        print_error "Utilisateur avec l'email '$user_email' introuvable"
        return 1
    fi

    # Demander le nouveau mot de passe
    echo -n "Nouveau mot de passe: "
    read -s new_password
    echo ""

    if [ -z "$new_password" ]; then
        print_error "Mot de passe requis"
        return 1
    fi

    # Générer le hash bcrypt du mot de passe
    print_message "🔒 Génération du hash sécurisé..."
    local password_hash=$(docker exec wordpress php -r "echo password_hash('$new_password', PASSWORD_BCRYPT);")

    # Mettre à jour le mot de passe dans la base
    print_message "💾 Mise à jour dans la base de données..."
    docker exec mariadb mariadb -u wordpress -pwordpress wordpress -e "UPDATE wp_users SET user_pass='$password_hash' WHERE user_email='$user_email';" 2>/dev/null

    if [ $? -eq 0 ]; then
        print_message "✅ Mot de passe mis à jour avec succès"
        echo ""
        echo -e "${GREEN}📧 Email:${NC} $user_email"
        echo -e "${GREEN}🔑 Nouveau mot de passe:${NC} configuré"
        echo -e "${GREEN}🌐 Connexion:${NC} http://localhost:8080/wp-admin/"
    else
        print_error "❌ Erreur lors de la mise à jour du mot de passe"
        return 1
    fi
}

# Menu principal
show_menu() {
    print_header
    echo -e "${BLUE}Actions disponibles:${NC}"
    echo ""
    echo "1. 🚀 Démarrer"
    echo "2. 🛑 Arrêter"
    echo "3. 🔄 Installation fraîche"
    echo "4. 🎨 Accéder au thème"
    echo "5. 📦 Réinstaller dépendances PHP"
    echo "6. 🔐 Changer mot de passe admin"
    echo ""
    echo -n "Choix (1-6): "
    read choice
    echo ""

    case $choice in
        1)
            check_requirements
            generate_wp_config
            start_services
            ;;
        2)
            stop_services
            ;;
        3)
            check_requirements
            fresh_install
            ;;
        4)
            theme_access
            ;;
        5)
            reinstall_php_dependencies
            ;;
        6)
            change_admin_password
            ;;
        *)
            print_error "Choix invalide. Usage: $0 [1-6]"
            exit 1
            ;;
    esac
}

# Exécution
if [ $# -eq 0 ]; then
    show_menu
else
    case $1 in
        1) check_requirements && generate_wp_config && start_services ;;
        2) stop_services ;;
        3) check_requirements && fresh_install ;;
        4) theme_access ;;
        5) reinstall_php_dependencies ;;
        6) change_admin_password ;;
        *) print_error "Argument invalide. Utilisation: $0 [1-6]" && exit 1 ;;
    esac
fi
