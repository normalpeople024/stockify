<?php
// app/Http/Middleware/LogActivity.php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }

    public function terminate(Request $request, $response): void
    {
        if (Auth::check()) {
            // Hanya log request yang penting, bukan semua request
            $routeName = $request->route()?->getName() ?? '';
            $method    = $request->method();

            // Jangan log request GET biasa (terlalu banyak)
            if ($method === 'GET') return;

            // Tentukan action dan module dari route name
            [$action, $module] = $this->parseRoute($routeName, $method);

            if ($action && $module) {
                ActivityLog::create([
                    'user_id'     => Auth::id(),
                    'action'      => $action,
                    'module'      => $module,
                    'description' => $this->buildDescription($action, $module, $request),
                    'ip_address'  => $request->ip(),
                    'user_agent'  => $request->userAgent(),
                ]);
            }
        }
    }

    private function parseRoute(string $route, string $method): array
    {
        $map = [
            'login.post'                => ['login',   'auth'],
            'logout'                    => ['logout',  'auth'],
            'admin.products.store'      => ['create',  'product'],
            'admin.products.update'     => ['update',  'product'],
            'admin.products.destroy'    => ['delete',  'product'],
            'admin.categories.store'    => ['create',  'category'],
            'admin.categories.update'   => ['update',  'category'],
            'admin.categories.destroy'  => ['delete',  'category'],
            'admin.suppliers.store'     => ['create',  'supplier'],
            'admin.suppliers.update'    => ['update',  'supplier'],
            'admin.suppliers.destroy'   => ['delete',  'supplier'],
            'admin.users.store'         => ['create',  'user'],
            'admin.users.update'        => ['update',  'user'],
            'admin.users.destroy'       => ['delete',  'user'],
            'manager.stock.store-in'    => ['create',  'stock'],
            'manager.stock.store-out'   => ['create',  'stock'],
            'manager.products.store'    => ['create',  'product'],
            'staff.stock.confirm'       => ['confirm', 'stock'],
            'staff.stock.reject'        => ['reject',  'stock'],
        ];

        return $map[$route] ?? [null, null];
    }

    private function buildDescription(string $action, string $module, $request): string
    {
        $user   = Auth::user()->name;
        $labels = [
            'login'   => "{$user} login ke sistem",
            'logout'  => "{$user} logout dari sistem",
            'create'  => "{$user} menambahkan data {$module}",
            'update'  => "{$user} memperbarui data {$module}",
            'delete'  => "{$user} menghapus data {$module}",
            'confirm' => "{$user} mengkonfirmasi transaksi stok",
            'reject'  => "{$user} menolak transaksi stok",
        ];
        return $labels[$action] ?? "{$user} melakukan {$action} pada {$module}";
    }
}
