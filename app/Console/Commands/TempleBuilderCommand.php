<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TempleBuilderCommand extends Command
{
    protected $signature = 'temple:builder';
    protected $description = 'Quickly scaffold a Livewire + Blade + Controller + Route for a temple module';

    public function handle()
    {
        // 1. Check if Livewire is installed
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $requires = array_merge($composer['require'] ?? [], $composer['require-dev'] ?? []);

        if (!array_key_exists('livewire/livewire', $requires)) {
            $this->error('⚠️  Livewire is not installed.');
            $this->line('👉 Run:');
            $this->line('    composer require livewire/livewire');
            return Command::FAILURE;
        }

        // 2. Check if Livewire is installed
        if (!File::exists(base_path('tailwind.config.js'))) {
            $this->warn('⚠️  Tailwind CSS is not installed.');

            if ($this->confirm('💬 Do you want to install Tailwind CSS now?')) {
                $this->info('📦 Installing Tailwind via npm...');
                exec('npm install -D tailwindcss postcss autoprefixer && npx tailwindcss init -p', $output, $status);

                if ($status === 0) {
                    $this->info('✅ Tailwind CSS installed and config generated.');
                } else {
                    $this->error('❌ Tailwind installation failed. Check your Node/npm setup.');
                    return Command::FAILURE;
                }
            } else {
                $this->line('⏭️ Skipped Tailwind installation.');
                return Command::FAILURE;
            }
        }


        // 2. Ensure directories exist
        $livewireClassDir = app_path('Livewire/TempleBuilder');
        $livewireViewDir = resource_path('views/livewire');

        if (!File::exists($livewireClassDir)) {
            File::makeDirectory($livewireClassDir, 0755, true);
            $this->info("📁 Created directory: $livewireClassDir");
        }

        if (!File::exists($livewireViewDir)) {
            File::makeDirectory($livewireViewDir, 0755, true);
            $this->info("📁 Created directory: $livewireViewDir");
        }

        // 3. Generate Livewire class file
        $stubClassPath = base_path('app/stubs/TempleBuilderClass.php.stub');
        $classTargetPath = $livewireClassDir . '/TempleBuilderView.php';

        if (!File::exists($stubClassPath)) {
            $this->error("❌ Missing stub: $stubClassPath");
            return Command::FAILURE;
        }

        File::put($classTargetPath, File::get($stubClassPath));
        $this->info("✅ Created Livewire class: $classTargetPath");

        // 4. Generate Livewire view file
        $stubViewPath = base_path('app/stubs/temple-builder-view.blade.php.stub');
        $viewTargetPath = $livewireViewDir . '/temple-builder-view.blade.php';

        if (!File::exists($stubViewPath)) {
            $this->error("❌ Missing stub: $stubViewPath");
            return Command::FAILURE;
        }

        File::put($viewTargetPath, File::get($stubViewPath));
        $this->info("✅ Created Livewire view: $viewTargetPath");

        $this->info("🎉 TempleBuilderView component setup complete.");
        return Command::SUCCESS;
    }

}
