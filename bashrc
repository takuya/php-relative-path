#!/usr/bin/env bash


function set_aliases() {
  alias phpunit=./vendor/bin/phpunit
  alias composer=./composer.phar

}
function download_composer() {
  if [[ ! -e composer.phar ]]; then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    #  php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
  fi
}


function main(){
  download_composer;
  set_aliases;

}

main;