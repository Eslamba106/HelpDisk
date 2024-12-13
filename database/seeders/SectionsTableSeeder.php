<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dashboards 1 - 2
        Section::updateOrCreate(['id' => 1], ['name' => 'admin_general_dashboard', 'caption' => 'General_Dashboard']);
        Section::updateOrCreate(['id' => 2], ['name' => 'admin_general_dashboard_show', 'section_group_id' => 1, 'caption' => "General_Dashboard_page"]);

        // Roles 3 - 7
        Section::updateOrCreate(['id' => 3], ['name' => 'Admin_Roles', 'caption' => 'Admin_Roles']);
        Section::updateOrCreate(['id' => 4], ['name' => 'Show_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Show_Admin_Roles']);
        Section::updateOrCreate(['id' => 5], ['name' => 'Create_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Create_Admin_Roles']);
        Section::updateOrCreate(['id' => 6], ['name' => 'Edit_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Edit_Admin_Roles']);
        Section::updateOrCreate(['id' => 7], ['name' => 'Update_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Update_Admin_Roles']);
        Section::updateOrCreate(['id' => 8], ['name' => 'Delete_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Delete_Admin_Roles']);

        // Users Management 9 - 15
        Section::updateOrCreate(['id' => 9], ['name' => 'user_management', 'caption' => 'user_management']);
        Section::updateOrCreate(['id' => 10], ['name' => 'all_users', 'section_group_id' => 9, 'caption' => 'show_all_users']);
        Section::updateOrCreate(['id' => 11], ['name' => 'change_users_role', 'section_group_id' => 9, 'caption' => 'change_users_role']);
        Section::updateOrCreate(['id' => 12], ['name' => 'change_users_status', 'section_group_id' => 9, 'caption' => 'change_users_status']);
        Section::updateOrCreate(['id' => 13], ['name' => 'delete_user', 'section_group_id' => 9, 'caption' => 'delete_user']);
        Section::updateOrCreate(['id' => 14], ['name' => 'edit_user', 'section_group_id' => 9, 'caption' => 'edit_user']);
        Section::updateOrCreate(['id' => 15], ['name' => 'create_user', 'section_group_id' => 9, 'caption' => 'create_user']);

        // Priority 16 - 20
        Section::updateOrCreate(['id' => 16], ['name' => 'priority', 'caption' => 'priorities']);
        Section::updateOrCreate(['id' => 17], ['name' => 'all_priority', 'section_group_id' => 16, 'caption' => 'all_priorities']);
        Section::updateOrCreate(['id' => 18], ['name' => 'add_new_priority', 'section_group_id' => 16, 'caption' => 'add_new_priority']);
        Section::updateOrCreate(['id' => 19], ['name' => 'edit_priority', 'section_group_id' => 16, 'caption' => 'edit_priority']);
        Section::updateOrCreate(['id' => 20], ['name' => 'delete_priority', 'section_group_id' => 16, 'caption' => 'delete_priority']);
        
        // Department 21 - 25
        Section::updateOrCreate(['id' => 21], ['name' => 'departments', 'caption' => 'departments']);
        Section::updateOrCreate(['id' => 22], ['name' => 'all_department', 'section_group_id' => 21, 'caption' => 'all_departments']);
        Section::updateOrCreate(['id' => 23], ['name' => 'create_department', 'section_group_id' => 21, 'caption' => 'create_department']);
        Section::updateOrCreate(['id' => 24], ['name' => 'edit_department', 'section_group_id' => 21, 'caption' => 'edit_department']);
        Section::updateOrCreate(['id' => 25], ['name' => 'delete_department', 'section_group_id' => 21, 'caption' => 'delete_department']);

        
        // Complaint 26 - 30
        Section::updateOrCreate(['id' => 26], ['name' => 'complaints', 'caption' => 'complaints']);
        Section::updateOrCreate(['id' => 27], ['name' => 'all_complaints', 'section_group_id' => 26, 'caption' => 'all_complaints']);
        Section::updateOrCreate(['id' => 28], ['name' => 'add_new_complaint', 'section_group_id' => 26, 'caption' => 'add_new_complaint']);
        Section::updateOrCreate(['id' => 29], ['name' => 'edit_complaint', 'section_group_id' => 26, 'caption' => 'edit_complaint']);
        Section::updateOrCreate(['id' => 30], ['name' => 'delete_complaint', 'section_group_id' => 26, 'caption' => 'delete_complaint']);

        
        /* Run Panel Sections */
        $this->runPanelSections();
    }
    private function runPanelSections()
    {

        // // Organization Instructors 1 - 9
        // $this->createPanelSection(['id' => 1], ['name' => 'panel_organization_instructors', 'caption' => 'Organization Instructors']);
        // $this->createPanelSection(['id' => 2], ['name' => 'panel_organization_instructors_lists', 'section_group_id' => 1, 'caption' => 'Lists']);
        // $this->createPanelSection(['id' => 3], ['name' => 'panel_organization_instructors_create', 'section_group_id' => 1, 'caption' => 'Create']);
        // $this->createPanelSection(['id' => 4], ['name' => 'panel_organization_instructors_edit', 'section_group_id' => 1, 'caption' => 'Edit']);
        // $this->createPanelSection(['id' => 5], ['name' => 'panel_organization_instructors_delete', 'section_group_id' => 1, 'caption' => 'Delete']);


    }

    private function createPanelSection($arr1, $arr2)
    {
        $prefixId = 100000;
        $arr2['type'] = "panel";

        if (!empty($arr2['section_group_id'])) {
            $arr2['section_group_id'] = $prefixId + $arr2['section_group_id'];
        }

        Section::updateOrCreate([
            'id' => $prefixId + $arr1['id'],
        ], $arr2);
    }
}
