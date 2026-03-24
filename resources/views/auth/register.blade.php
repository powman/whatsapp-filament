<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - WhatsApp Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-hero {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
        }
        .bg-gradient-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
        }
    </style>
</head>
<body class="gradient-hero min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">WhatsApp Manager</span>
            </a>
            <h1 class="text-white text-2xl font-bold mt-4">Crie sua conta gratuita</h1>
            <p class="text-green-200 mt-1">Comece a gerenciar suas conexões WhatsApp hoje</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Seu Nome Completo
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="João Silva"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('name') border-red-400 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nome da Empresa
                    </label>
                    <input
                        type="text"
                        id="company"
                        name="company"
                        value="{{ old('company') }}"
                        required
                        placeholder="Minha Empresa Ltda"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('company') border-red-400 @enderror"
                    >
                    @error('company')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        E-mail Corporativo
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="joao@empresa.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('email') border-red-400 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Senha
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Mínimo 8 caracteres"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('password') border-red-400 @enderror"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Confirmar Senha
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Repita a senha"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-whatsapp text-white py-3.5 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-emerald-200 transition-all mt-2"
                >
                    Criar Conta Gratuita →
                </button>
            </form>

            <div class="text-center mt-6 text-sm text-gray-500">
                Já tem uma conta?
                <a href="/admin/login" class="text-emerald-600 font-semibold hover:underline ml-1">
                    Fazer Login
                </a>
            </div>

            <p class="text-center text-xs text-gray-400 mt-4">
                Ao criar uma conta, você concorda com nossos termos de uso.
            </p>
        </div>

        <div class="text-center mt-6">
            <a href="/" class="text-green-200 hover:text-white text-sm transition-colors">
                ← Voltar para o início
            </a>
        </div>
    </div>

</body>
</html>
