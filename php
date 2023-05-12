#!/usr/bin/env sh
# Usage: lixreq php <phpversion: {N.N}>

set +e

me="php"
echo ''
echo === Setup $me ===
phpversion="$1"

test -n "$phpversion" || { echo "$me: Parameter 1 is missing: phpversion" >&2; exit 1; } 

pkgreq zip
pkgreq unzip
if [ "$ENV_DIST_NAME" = "alpine" ]; then
	phpversion="$(echo $phpversion | sed 's/\.//g')"
	if ! testcmd php; then
		pkgreq php$phpversion
		echo '# php' >> "$ENV_SHELL_RC"
		echo "alias php=php$phpversion" >> "$ENV_SHELL_RC"
		sourcerc
	fi
elif [ "$ENV_DIST_NAME" = "debian" ]; then
	if ! testcmd php; then
		pkgreq wget lsb-release
		wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
		echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php$phpversion.list
		apt-get update
		pkgreq php$phpversion
	fi
fi
pkgreq \
	php$phpversion-common \
	php$phpversion-cli \
	php$phpversion-curl \
	php$phpversion-gd \
	php$phpversion-gmp \
	php$phpversion-imap \
	php$phpversion-intl \
	php$phpversion-mbstring \
	php$phpversion-fileinfo \
	php$phpversion-session \
	php$phpversion-soap \
	php$phpversion-pgsql \
	php$phpversion-sqlite3 \
	php$phpversion-pdo \
	php$phpversion-phar \
	php$phpversion-tokenizer \
	php$phpversion-dom \
	php$phpversion-xml \
	php$phpversion-xmlwriter \
	php$phpversion-json \
	php$phpversion-zip
	pkgreqany php$phpversion-mysql php$phpversion-mysqli
	pkgreqany php$phpversion-pdo_mysql php$phpversion-pdo-mysql
	pkgreqany php$phpversion-pdo_pgsql php$phpversion-pdo-pgsql
	pkgreqany php$phpversion-pdo_sqlite php$phpversion-pdo-sqlite

	set -e

