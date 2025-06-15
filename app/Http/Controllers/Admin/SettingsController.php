<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return [
                'site_name' => config('app.name'),
                'site_description' => config('app.description', ''),
                'contact_email' => config('app.contact_email', ''),
                'contact_phone' => config('app.contact_phone', ''),
                'maintenance_mode' => config('app.maintenance_mode', false),
                'maintenance_message' => config('app.maintenance_message', ''),
            ];
        });

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'maintenance_mode' => ['boolean'],
            'maintenance_message' => ['nullable', 'string'],
        ]);

        // Mettre à jour les paramètres dans le cache
        Cache::put('site_settings', $validated, 3600);

        // Mettre à jour les paramètres dans le fichier .env
        $this->updateEnvFile($validated);

        return redirect()
            ->route('admin.settings')
            ->with('success', __('messages.admin.settings.updated'));
    }

    private function updateEnvFile($settings)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        $envContent = $this->updateEnvVariable($envContent, 'APP_NAME', $settings['site_name']);
        $envContent = $this->updateEnvVariable($envContent, 'APP_DESCRIPTION', $settings['site_description']);
        $envContent = $this->updateEnvVariable($envContent, 'CONTACT_EMAIL', $settings['contact_email']);
        $envContent = $this->updateEnvVariable($envContent, 'CONTACT_PHONE', $settings['contact_phone']);
        $envContent = $this->updateEnvVariable($envContent, 'MAINTENANCE_MODE', $settings['maintenance_mode'] ? 'true' : 'false');
        $envContent = $this->updateEnvVariable($envContent, 'MAINTENANCE_MESSAGE', $settings['maintenance_message']);

        file_put_contents($envFile, $envContent);
    }

    private function updateEnvVariable($content, $key, $value)
    {
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}=\"{$value}\"";
        
        if (preg_match($pattern, $content)) {
            return preg_replace($pattern, $replacement, $content);
        }
        
        return $content . "\n{$replacement}";
    }
} 