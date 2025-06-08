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

    public function mount()
    {
        // $this->refreshRoutes();
    }

    public function refreshRoutes()
    {
        $this->routes = $this->getNestedRoutes();
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

    public function getNestedRoutes()
    {
        // Step 1: Get all routes and filter only Livewire ones with names
        $flatRoutes = collect(Route::getRoutes())
            ->filter(function ($r) {
                return $r->getName() && str_starts_with($r->getActionName(), 'App\\Livewire');
            })
            ->map(function ($r) {
                // Extract Livewire component class from action name
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

        // Debug: Log or Dump flat route data
        Log::info('Flat Routes:', $flatRoutes->toArray());

        // Step 2: Convert flat list to nested tree
        $tree = [];
        foreach ($flatRoutes as $route) {
            $current = &$tree;
            foreach ($route['segments'] as $segment) {
                $current = &$current['children'][$segment];
            }
            $current['route'] = $route;
        }

        // Debug: Log raw nested tree before formatting
        Log::info('Raw Tree:', $tree);

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
        return view('livewire.templebuilder.route-explorer');
    }
}