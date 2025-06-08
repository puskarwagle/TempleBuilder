1. ❓ Ask user:
   "Do you want me to install Livewire, Alpine.js, Tailwind CSS, and DaisyUI for you?"

   ⮑ If user says yes:
      - Run:
        - composer require livewire/livewire
        - npm install -D tailwindcss postcss autoprefixer
        - npx tailwindcss init -p
        - npm install -D daisyui
        - npm install alpinejs

      - Modify `resources/css/app.css`:
        - If `@import "tailwindcss";` is missing, insert it at the top.
        - Append `@plugin "daisyui";` after @imports if not present.

      - ✅ Then notify user:
        - Livewire, Alpine, Tailwind, and DaisyUI installed
        - app.css updated

   ⮑ If user says no:
      - Exit with: "Setup cancelled by user."

  if the user says continue without installation then continue without installation.

2. 📁 Ensure dirs:
   - `app/Livewire/TempleBuilder`
   - `resources/views/livewire/templebuilder`

3. 📄 Copy stubs:
   - `TempleBuilder.php.stub` → `app/Livewire/TempleBuilder/TempleBuilder.php`
   - `temple-builder.blade.php.stub` → `resources/views/livewire/templebuilder/temple-builder.blade.php`
   - `RouteExplorer.php.stub` → `app/Livewire/TempleBuilder/RouteExplorer.php`
   - `route-explorer.blade.php.stub` → `resources/views/livewire/templebuilder/route-explorer.blade.php`
   - `route-node.blade.php.stub` → `resources/views/livewire/templebuilder/route-node.blade.php`
   - `welcome.blade.php.stub` → `resources/views/welcome.blade.php`

4. 🎉 Success message:
   if installed the with tech - "TempleBuilder setup complete. Tailwind + DaisyUI integrated. Stubs deployed. All ready to roll."
  if continued without installation - "Stubs deployed. Make sure you have livewire, tailwind, daisy and alpinejs installed."
