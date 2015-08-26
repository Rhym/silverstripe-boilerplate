<?php

/**
 * Class BoilerplateGroupExtension
 *
 * @mixin Group
 */
class BoilerplateGroupExtension extends DataExtension
{
    /**
     * @throws ValidationException
     * @throws null
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        /**
         * Add default site admin group if none with
         * permission code SITE_ADMIN exists
         *
         * @var Group $siteAdminGroup
         */
        $siteAdminGroups = DataObject::get('Group')->filter(array('Code' => 'site-administrators'));
        if (!$siteAdminGroups->count()) {
            $siteAdminGroup = Group::create();
            $siteAdminGroup->Code = 'site-administrators';
            $siteAdminGroup->Title = 'Site Administrators';
            $siteAdminGroup->Sort = 0;
            $siteAdminGroup->write();

            /** Default CMS permissions */
            Permission::grant($siteAdminGroup->ID, 'CMS_ACCESS_LeftAndMain');
            Permission::grant($siteAdminGroup->ID, 'SITETREE_VIEW_ALL');
            Permission::grant($siteAdminGroup->ID, 'SITETREE_EDIT_ALL');
            Permission::grant($siteAdminGroup->ID, 'SITETREE_REORGANISE');
            Permission::grant($siteAdminGroup->ID, 'VIEW_DRAFT_CONTENT');
            Permission::grant($siteAdminGroup->ID, 'SITETREE_GRANT_ACCESS');
            Permission::grant($siteAdminGroup->ID, 'EDIT_SITECONFIG');
        }
    }

}
