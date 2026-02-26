<?php

declare(strict_types=1);

namespace RS\Theme\App;

use stdClass;

class Filters
{
    public function addsIconToMenuItemLink(array $sortedMenuItems, stdClass $args): array
    {
        foreach ($sortedMenuItems as $menuItem) {
            $icon = get_field('menu_item_icon', $menuItem);
            if (empty($icon)) {
                $menuItem->title = $menuItem->title . '<span class="wave" aria-hidden="true"></span>';
                continue;
            }

            $icon = wp_get_attachment_image($icon, 'full');
            $menuItem->title = '<span class="header-menu-icon">' . $icon . '</span>' . $menuItem->title . '<span class="wave wave--w-icon" aria-hidden="true"></span>';
        }

        return $sortedMenuItems;
    }

    public function disableFormattingOnCF7(): bool
    {
        return false;
    }
}
