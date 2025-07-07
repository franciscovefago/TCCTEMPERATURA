#!/bin/bash

# Inicia o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000 &

# Inicia o listener MQTT
php artisan mqtt:listen &

# Inicia o Vite
npm run dev

# Espera todos os processos
wait
