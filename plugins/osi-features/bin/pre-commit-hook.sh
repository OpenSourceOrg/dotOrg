#!/bin/bash

# Add pre-commit hook to .git/hooks/pre-commit
if [ "$1" == "--install" ]; then
	echo "set -e; composer run-script pre-commit" > .git/hooks/pre-commit
	chmod +x .git/hooks/pre-commit
	echo -e "\e[1m\e[32mPre-commit hook installed successfully\e[0m"
fi

# Remove pre-commit hook from .git/hooks/pre-commit if --remove is passed
if [ "$1" == "--remove" ]; then
	rm .git/hooks/pre-commit
	echo -e "\e[1m\e[32mPre-commit hook removed successfully\e[0m"
fi
