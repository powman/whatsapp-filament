@extends('filament::page')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Escanear código QR</h1>

    @if($qrCode)
        <div class="mb-6 text-center">
            <img src="{{ $qrCode }}" alt="QR Code" class="w-full max-w-xs mx-auto border-2 border-gray-300 rounded">
        </div>

        <p class="text-gray-600 text-center mb-6">
            Escaneie este código QR com seu telefone para conectar o WhatsApp
        </p>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-sm text-blue-700">
                <strong>Dica:</strong> Abra o WhatsApp no seu telefone e mantenha a câmera apontada para o código QR até que a conexão seja estabelecida.
            </p>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
            <p class="text-sm text-yellow-700">
                Nenhum código QR disponível. Clique no botão "Conectar" novamente.
            </p>
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('filament.admin.resources.whatsapp-connections.index') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
            Voltar
        </a>
    </div>
</div>
@endsection
