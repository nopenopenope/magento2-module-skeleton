#!/usr/bin/env bash

if [ $# -ne 3 ]; then
    echo "Usage: $0 <REPO_URL> <VENDOR_NAME> <MODULE_NAME>"
    exit 1
fi

# Repository URL provided as an argument
REPO_URL="$1"
VENDOR="$2"
MODULE="$3"

# Folder where the repository will be cloned
clone_folder="/var/www/html/app/code/$VENDOR/$MODULE"

# Check if the destination folder exists, if not, create it
rm -rf "$clone_folder"
if [ ! -d /var/www/html/app/code/$VENDOR ]; then
    mkdir -p /var/www/html/app/code/$VENDOR
fi

git clone "$REPO_URL" "$clone_folder"

if [ $? -eq 0 ]; then
    echo "Repository cloned successfully to: $clone_folder"
else
    echo "Failed to clone the repository."
    exit 1
fi
