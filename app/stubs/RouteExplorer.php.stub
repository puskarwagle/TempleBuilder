<?php
namespace App\Livewire\TempleBuilder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RouteExplorer extends Component
{
   public $routes = [];
   public $selectedComponent = null;
   public $selectedRoute = null;
   public bool $filterLivewireOnly = true;

   // Routes to exclude from frontend display
   private array $excludedRoutes = [
       'temple-builder',
       'route-explorer', 
       'logout'
   ];

   public function mount()
   {
       $this->refreshRoutes(true);
   }

   public function refreshRoutes()
   {
       $this->routes = $this->getNestedRoutes($this->filterLivewireOnly);
   }

   public function selectComponent($routeName, $componentClass)
   {
       $this->selectedComponent = $componentClass;
       $this->selectedRoute = $routeName;
       
       // Emit event to update preview area
       $this->dispatch('component-selected', [
           'component' => $componentClass,
           'route' => $routeName
       ]);
   }

   public function getNestedRoutes(bool $onlyLivewire = true)
   {
       $flatRoutes = collect(Route::getRoutes())
           ->filter(function ($r) use ($onlyLivewire) {
               return $r->getName() &&
                   (!$onlyLivewire || str_starts_with($r->getActionName(), 'App\\Livewire')) &&
                   !in_array($r->getName(), $this->excludedRoutes);
           })
           ->map(function ($r) {
               $actionName = $r->getActionName();
               $componentClass = str_replace('App\\Livewire\\', '', $actionName);

               return [
                   'name' => $r->getName(),
                   'uri' => $r->uri(),
                   'segments' => explode('.', $r->getName()),
                   'component_class' => $componentClass,
                   'full_class' => $actionName,
               ];
           });

       // Log::info('Flat Routes:', $flatRoutes->toArray());

       // Convert to tree
       $tree = [];
       foreach ($flatRoutes as $route) {
           $current = &$tree;
           foreach ($route['segments'] as $segment) {
               $current = &$current['children'][$segment];
           }
           $current['route'] = $route;
       }

       // Log::info('Raw Tree:', $tree);

       return $this->formatTree($tree['children'] ?? []);
   }

   private function formatTree($branch)
   {
       // Debug: Show what branch is being formatted
       Log::info('Formatting Branch:', $branch);

       return collect($branch)->map(function ($node, $key) {
           return [
               'label' => $key,
               'route' => $node['route'] ?? null,
               'children' => isset($node['children']) ? $this->formatTree($node['children']) : [],
           ];
       })->values()->toArray();
   }

   public function render()
   {
        //    dd($this->routes);
           return view('livewire.templebuilder.route-explorer');
   }
}