# Route Naming Fix - Module 5

## Issue
When navigating to `/projets`, the application threw a `RouteNotFoundException`:
```
Route [front.project.index] not defined.
```

## Root Cause
The views were using route names with `front.` prefix (e.g., `route('front.project.index')`), but the actual routes were registered with just `project.*` namespace.

**Route Definition** (in `routes/front/project.php`):
```php
Route::prefix('projets')->name('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});
```

This creates routes named:
- `project.index` ✅
- `project.show` ✅

NOT:
- `front.project.index` ❌
- `front.project.show` ❌

## Solution
Updated all route references in the views to use the correct naming:

### Files Modified

**1. `resources/views/components/project/front/index.blade.php`**
- Changed: `route('front.project.index')` → `route('project.index')`
- Changed: `route('front.project.show', $project)` → `route('project.show', $project)`
- Occurrences: 3 places (form action, reset link, project card link)

**2. `resources/views/components/shared/navbar.blade.php`**
- Already correct: `route('project.index')`
- Commented out admin link (not yet created): `route('admin.project.index')`

## Verification
After the fix, run:
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan route:list --name=project
```

Expected output:
```
GET|HEAD  projets ................. project.index › Front\Project\ProjectController@index
GET|HEAD  projets/{project} ....... project.show › Front\Project\ProjectController@show
```

## Testing
1. Visit `http://127.0.0.1:8000/projets` - should load project index
2. Click on any project card - should load project details
3. Use filters - should submit to correct route
4. Click "Réinitialiser" - should clear filters and reload index

## Future Admin Routes
When creating admin routes, follow the same naming convention:

**Option 1: Separate namespace**
```php
// In routes/admin/project.php
Route::prefix('admin/projets')->name('admin.project.')->group(function () {
    Route::get('/', [AdminProjectController::class, 'index'])->name('index');
    // Creates: admin.project.index
});
```

**Option 2: Same namespace with middleware**
```php
// In routes/front/project.php
Route::prefix('projets')->name('project.')->group(function () {
    // Public routes (already exists)
    
    Route::middleware(['auth', 'role:gestionnaire,admin'])->group(function () {
        Route::get('/manage', [ProjectController::class, 'manage'])->name('manage');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        // Creates: project.manage, project.store
    });
});
```

## Consistency Rules
1. **Route prefix** (`/projets`) → URL path
2. **Route name prefix** (`project.`) → Route name namespace
3. **Route name** (`.index`) → Route identifier
4. **Final route name** = prefix + name = `project.index`

Always verify route names with:
```bash
php artisan route:list --name=<your-prefix>
```

## Related Files
- `routes/front/project.php` - Route definitions
- `app/Http/Controllers/Front/Project/ProjectController.php` - Controller
- `resources/views/components/project/front/index.blade.php` - View
- `resources/views/components/shared/navbar.blade.php` - Navigation
