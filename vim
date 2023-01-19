#!/usr/bin/env bash
# Usage: lxcreq vim

set +e

me="vim"
echo ''
echo === Setup $me ===

if ! testc vim; then
	pkgreq vim
	echo "set number\nset relativenumber" > $HOME/.vimrc
fi

set -e

