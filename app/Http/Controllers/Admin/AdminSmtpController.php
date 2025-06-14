<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminSmtpController extends Controller
{
    public function edit()
    {
        $smtp = [
            'mailer' => env('MAIL_MAILER'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'from_address' => env('MAIL_FROM_ADDRESS'),
            'from_name' => env('MAIL_FROM_NAME'),
        ];

        return view('admin.smtp.edit', compact('smtp'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required|integer',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'nullable',
            'from_address' => 'required|email',
            'from_name' => 'required',
        ]);

        foreach ($data as $key => $value) {
            $this->setEnv(strtoupper("MAIL_" . ($key === 'mailer' ? 'MAILER' : $key)), $value);
        }

        // Limpiar cache de configuración si existía
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Configuración SMTP actualizada correctamente.');
    }

    private function setEnv($key, $value)
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) return;

        // Si el valor tiene espacios o caracteres especiales, lo envolvemos en comillas dobles
        $needsQuotes = preg_match('/\s/', $value) || str_contains($value, '#');
        $escapedValue = $needsQuotes ? '"' . addslashes($value) . '"' : $value;

        $content = file_get_contents($envPath);

        if (strpos($content, "$key=") !== false) {
            $content = preg_replace("/^$key=.*/m", "$key=$escapedValue", $content);
        } else {
            $content .= "\n$key=$escapedValue";
        }

        file_put_contents($envPath, $content);
    }
}
