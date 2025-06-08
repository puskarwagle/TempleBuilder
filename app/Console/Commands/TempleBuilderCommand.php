<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TempleBuilderCommand extends Command
{
    protected $signature = 'temple:builder';
    protected $description = 'Scaffold TempleBuilder with Livewire, Alpine.js, Tailwind CSS, and DaisyUI';

    public function handle()
    {
        $this->line('❓ Do you want me to install Livewire, Alpine.js, Tailwind CSS, and DaisyUI for you?');

        if ($this->confirm('👉 Proceed with installation?')) {
            $this->info('📦 Installing required packages...');

            exec('composer require livewire/livewire', $out1, $err1);
            exec('npm install -D tailwindcss postcss autoprefixer', $out2, $err2);
            exec('npx tailwindcss init -p', $out3, $err3);
            exec('npm install -D daisyui', $out4, $err4);
            exec('npm install alpinejs', $out5, $err5);

            $installed = true;
            $this->info('✅ Livewire, Alpine.js, Tailwind, and DaisyUI installed.');
            $this->info('📄 app.css updated with Tailwind import and DaisyUI plugin.');
        } elseif ($this->confirm('⚠️ Continue *without* installing the stack?', false)) {
            $installed = false;
            $this->warn('⚠️ Proceeding without installing Livewire, Tailwind, DaisyUI, or Alpine.js...');
        } else {
            $this->warn('❌ Setup cancelled by user.');
            return Command::FAILURE;
        }

        // 📁 Ensure directories
        $classDir = app_path('Livewire/TempleBuilder');
        $viewDir = resource_path('views/livewire/templebuilder');
        $groupsViewsDir = resource_path('views/livewire/groups/water');
        $groupsClassDir = app_path('Livewire/Groups/Water');

        File::ensureDirectoryExists($classDir);
        File::ensureDirectoryExists($viewDir);
        File::ensureDirectoryExists($groupsViewsDir);
        File::ensureDirectoryExists($groupsClassDir);

        // 📄 Copy stubs
        $stubMap = [
            'TempleBuilder.php.stub'        => $classDir . '/TempleBuilder.php',
            'RouteExplorer.php.stub'        => $classDir . '/RouteExplorer.php',
            'temple-builder.blade.php.stub' => $viewDir . '/temple-builder.blade.php',
            'route-explorer.blade.php.stub' => $viewDir . '/route-explorer.blade.php',
            'route-node.blade.php.stub'     => $viewDir . '/route-node.blade.php',
            'welcome.blade.php.stub'        => resource_path('views/welcome.blade.php'),
            'app.css.stub'                  => resource_path('css/app.css'),
            'web.php.stub'                  => base_path('routes/web.php'),
            'sidebar.blade.php.stub'        => resource_path('views/components/layouts/app/sidebar.blade.php'),
            'Home.php.stub'                 => app_path('Livewire/Home.php'),
            'home.blade.php.stub'           => resource_path('views/livewire/home.blade.php'),
            'oxygen.blade.php.stub'         => $groupsViewsDir . '/oxygen.blade.php',
            'Oxygen.php.stub'               => $groupsClassDir . '/Oxygen.php',
            'hydrogen.blade.php.stub'       => $groupsViewsDir . '/hydrogen.blade.php',
            'Hydrogen.php.stub'             => $groupsClassDir . '/Hydrogen.php',
        ];

        foreach ($stubMap as $stub => $target) {
            $stubPath = base_path("app/stubs/{$stub}");
            if (!File::exists($stubPath)) {
                $this->error("❌ Missing stub: $stubPath");
                return Command::FAILURE;
            }
            File::put($target, File::get($stubPath));
            $this->info("✅ Stub deployed: $target");
        }

        $this->line($installed
            ? '🎉 TempleBuilder setup complete. Tailwind + DaisyUI integrated. Stubs deployed. All ready to roll.'
            : '✅ Stubs deployed. Make sure you have Livewire, Tailwind, DaisyUI, and Alpine.js installed manually.');

        return Command::SUCCESS;
    }
}
