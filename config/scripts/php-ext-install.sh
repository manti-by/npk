#!/bin/bash
set -e

cd /usr/src/php/ext

usage() {
	echo "usage: $0 ext-name [ext-name ...]"
	echo "   ie: $0 gd mysqli"
	echo "       $0 pdo pdo_mysql"
	echo
	echo 'if custom ./configure arguments are necessary, see docker-php-ext-configure'
	echo
	echo 'Possible values for ext-name:'
	echo $(find /usr/src/php/ext -mindepth 2 -maxdepth 2 -type f -name 'config.m4' | cut -d/ -f6 | sort)
}

exts=()
while [ $# -gt 0 ]; do
	ext="$1"
	shift
	if [ -z "$ext" ]; then
		continue
	fi
	if [ ! -d "$ext" ]; then
		echo >&2 "error: $(pwd -P)/$ext does not exist"
		echo >&2
		usage >&2
		exit 1
	fi
	exts+=( "$ext" )
done

if [ "${#exts[@]}" -eq 0 ]; then
	usage >&2
	exit 1
fi

for ext in "${exts[@]}"; do
	(
		cd "$ext"
		[ -e Makefile ] || php-ext-configure "$ext"
		make
		make install
		ini="/etc/php/conf.d/ext-$ext.ini"
		for module in modules/*.so; do
			if [ -f "$module" ]; then
				if grep -q zend_extension_entry "$module"; then
					# https://wiki.php.net/internals/extensions#loading_zend_extensions
					line="zend_extension=$(basename "$module")"
				else
					line="extension=$(basename "$module")"
				fi
				if ! grep -q "$line" "$ini"; then
					echo "$line" >> "/etc/php/conf.d/ext-$ext.ini"
				fi
			fi
		done
		make clean
	)
done
