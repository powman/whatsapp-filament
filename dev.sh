#!/bin/bash

# Script para iniciar stack Docker completo para desenvolvimento local

PROJECT_DIR="/home/paulohenrique/Documentos/WEBSITE/whatsapp-filament"
cd "$PROJECT_DIR"

echo "🚀 Iniciando stack Docker para desenvolvimento local..."
echo ""

# Verifica se Docker está rodando
if ! docker ps > /dev/null 2>&1; then
    echo "❌ Docker não está rodando. Inicie o Docker e tente novamente."
    exit 1
fi

# Inicia Docker Compose
echo "📦 Iniciando Docker Compose..."
echo ""

sudo docker compose up

echo ""
echo "🛑 Serviços encerrados."

