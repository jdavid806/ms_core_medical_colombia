<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\UserPermission;
use App\Repositories\UserRoleRepository;

class UserRoleService extends BaseService
{
    protected $repository;

    public function __construct(
        UserRoleRepository $repository,
        private UserRolePermissionService $userRolePermissionService,
        private UserRoleMenuService $userRoleMenuService
    ) {
        $this->repository = $repository;
    }

    public function storeWithMenusAndPermissions($data)
    {
        $roleData = $data['role'];
        $permissionsKeys = $data['permissions'];
        $menusKeys = $data['menus'];
        $role = $this->repository->create($roleData);

        $permissionsByKeys = [];
        foreach ($permissionsKeys as $key) {
            $permission = UserPermission::firstOrCreate(['key' => $key]);
            $permissionsByKeys[] = $permission->id;
        }

        $menusByKeys = [];
        foreach ($menusKeys as $key) {
            $menu = Menu::firstOrCreate(['key' => $key]);
            $menusByKeys[] = $menu->id;
        }

        $role->permissions()->sync($permissionsByKeys);
        $role->menus()->sync($menusByKeys);
    }

    public function  updateWithMenusAndPermissions($id, $data)
    {
        $role = $this->repository->find($id);

        if (array_key_exists('role', $data)) {
            $role = $this->repository->update($id, $data['role']);
        }

        $permissionsKeys = $data['permissions'] ?? [];
        $menusKeys = $data['menus'] ?? [];
        $permissionsByKeys = [];
        $menusByKeys = [];

        foreach ($permissionsKeys as $key) {
            $permission = UserPermission::firstOrCreate(['key' => $key]);
            $permissionsByKeys[] = $permission->id;
        }

        foreach ($menusKeys as $key) {
            $menu = Menu::firstOrCreate(['key' => $key]);
            $menusByKeys[] = $menu->id;
        }

        $role->permissions()->sync($permissionsByKeys);
        $role->menus()->sync($menusByKeys);
    }
}
