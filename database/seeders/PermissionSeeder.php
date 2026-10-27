<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            ['name' => 'dashboard-view', 'group_name' => 'Dashboard'],

            // Contact Leads
            ['name' => 'contact-leads-view', 'group_name' => 'Contact Leads'],

            // Home Page Modules
            ['name' => 'slider-view', 'group_name' => 'Home Page'],
            ['name' => 'slider-create', 'group_name' => 'Home Page'],
            ['name' => 'slider-edit', 'group_name' => 'Home Page'],
            ['name' => 'slider-delete', 'group_name' => 'Home Page'],
            
            ['name' => 'testimonial-view', 'group_name' => 'Home Page'],
            ['name' => 'testimonial-create', 'group_name' => 'Home Page'],
            ['name' => 'testimonial-edit', 'group_name' => 'Home Page'],
            ['name' => 'testimonial-delete', 'group_name' => 'Home Page'],
            
            ['name' => 'faq-view', 'group_name' => 'Home Page'],
            ['name' => 'faq-create', 'group_name' => 'Home Page'],
            ['name' => 'faq-edit', 'group_name' => 'Home Page'],
            ['name' => 'faq-delete', 'group_name' => 'Home Page'],

            // About Us Modules
            ['name' => 'chairman-message-view', 'group_name' => 'About Us'],
            ['name' => 'chairman-message-edit', 'group_name' => 'About Us'],
            
            ['name' => 'director-message-view', 'group_name' => 'About Us'],
            ['name' => 'director-message-edit', 'group_name' => 'About Us'],

            // Courses
            ['name' => 'course-view', 'group_name' => 'Courses'],
            ['name' => 'course-create', 'group_name' => 'Courses'],
            ['name' => 'course-edit', 'group_name' => 'Courses'],
            ['name' => 'course-delete', 'group_name' => 'Courses'],

            // Blogs
            ['name' => 'blog-view', 'group_name' => 'Blogs'],
            ['name' => 'blog-create', 'group_name' => 'Blogs'],
            ['name' => 'blog-edit', 'group_name' => 'Blogs'],
            ['name' => 'blog-delete', 'group_name' => 'Blogs'],

            // Gallery
            ['name' => 'gallery-view', 'group_name' => 'Gallery'],
            ['name' => 'gallery-create', 'group_name' => 'Gallery'],
            ['name' => 'gallery-edit', 'group_name' => 'Gallery'],
            ['name' => 'gallery-delete', 'group_name' => 'Gallery'],

            // Students
            ['name' => 'student-view', 'group_name' => 'Students'],
            ['name' => 'student-create', 'group_name' => 'Students'],
            ['name' => 'student-edit', 'group_name' => 'Students'],
            ['name' => 'student-delete', 'group_name' => 'Students'],

            // Results
            ['name' => 'result-view', 'group_name' => 'Results'],
            ['name' => 'result-create', 'group_name' => 'Results'],
            ['name' => 'result-edit', 'group_name' => 'Results'],
            ['name' => 'result-delete', 'group_name' => 'Results'],

            // Certificates
            ['name' => 'certificate-view', 'group_name' => 'Certificates'],
            ['name' => 'certificate-create', 'group_name' => 'Certificates'],
            ['name' => 'certificate-edit', 'group_name' => 'Certificates'],
            ['name' => 'certificate-delete', 'group_name' => 'Certificates'],

            // Fee Receipts
            ['name' => 'fee-view', 'group_name' => 'Fee Receipts'],
            ['name' => 'fee-create', 'group_name' => 'Fee Receipts'],
            ['name' => 'fee-edit', 'group_name' => 'Fee Receipts'],
            ['name' => 'fee-delete', 'group_name' => 'Fee Receipts'],

            // Administration (Users, Roles, Permissions)
            ['name' => 'user-view', 'group_name' => 'Administration'],
            ['name' => 'user-create', 'group_name' => 'Administration'],
            ['name' => 'user-edit', 'group_name' => 'Administration'],
            ['name' => 'user-delete', 'group_name' => 'Administration'],
            
            ['name' => 'role-view', 'group_name' => 'Administration'],
            ['name' => 'role-create', 'group_name' => 'Administration'],
            ['name' => 'role-edit', 'group_name' => 'Administration'],
            ['name' => 'role-delete', 'group_name' => 'Administration'],
            ['name' => 'permission-view', 'group_name' => 'Administration'],
            ['name' => 'permission-create', 'group_name' => 'Administration'],
            ['name' => 'permission-edit', 'group_name' => 'Administration'],

            // Settings
            ['name' => 'setting-view', 'group_name' => 'Settings'],
            ['name' => 'setting-edit', 'group_name' => 'Settings'],
            
            ['name' => 'seo-view', 'group_name' => 'Settings'],
            ['name' => 'seo-edit', 'group_name' => 'Settings'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                ['group_name' => $perm['group_name'], 'status' => true]
            );
        }
    }
}