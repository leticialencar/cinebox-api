<x-mail::message>

Olá, {{ $notifiable->name }}!

Recebemos uma solicitação para redefinir a senha da sua conta no **CineBox**.

Se foi você quem solicitou, clique no botão abaixo para criar uma nova senha:

<x-mail::button :url="$url" style="background-color: #8042e8;">
Redefinir minha senha
</x-mail::button>

<div style="border-left: 4px solid #8042e8; background-color: rgba(128, 66, 232, 0.08); border-radius: 6px; padding: 14px 16px; margin: 21px 0; font-size: 15px; color: #a1a1aa;">
    Este link é válido por <strong>60 minutos</strong> a partir do momento em que foi gerado.
</div>

Se você não solicitou a redefinição de senha, pode ignorar este e-mail com segurança. Sua conta continua protegida.

— Equipe CineBox

@slot('subcopy')
Se você está tendo problemas para clicar no botão "Redefinir minha senha", copie e cole a URL abaixo no seu navegador:
<span class="break-all">[{{ $url }}]({{ $url }})</span>
@endslot

</x-mail::message>