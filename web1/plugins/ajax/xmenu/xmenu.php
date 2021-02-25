<?php

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

jimport('joomla.plugin.plugin');

class plgAjaxXmenu extends JPlugin
{

    function onAjaxXmenu()
    {
        $input = JFactory::getApplication()->input;
        $action = $input->post->get('action', '', 'STRING');

        if ($_POST['data']) {
            $data = json_decode(json_encode($_POST['data']), true);;
            $action = $data['action'];
            $layoutName = '';

            if (isset($data['layoutName'])) {
                $layoutName = $data['layoutName'];
            }

            switch ($action) {
                case 'resetLayout':
                    echo self::resetMenuLayout($layoutName);
                    die();
                    break;

                default:
                    break;
            }

            return json_encode($report);
        }
        
    }

    static public function resetMenuLayout($current_menu_id = 0){

        if (!$current_menu_id) {
            return;           
        }

        $items  = self::menuItems();
        $item   = array();
        
        if (isset($items[$current_menu_id]) && !empty($items[$current_menu_id])) {
            $item = $items[$current_menu_id];
        }

        $menuItems = new JMenuSite;

        $no_child = true;
        $count = 0;
        $x_key = 0;
        $y_key = 0;
        $check_child = 0;
        $item_array = array();

        foreach ($item as $key => $id){
            $status = 0;
            if (isset($items[$id]) && is_array($items[$id])){
                $no_child = false;
                $count = $count + 1;
                $check_child = $check_child+1;
                $status = 1;
            }

            if ($check_child === 2){
                $y_key = 0;
                $x_key = $x_key + 1;
                $check_child = 1;
            }

            $item_array[$x_key][$y_key] = array($id,$status);
            $y_key = $y_key + 1;
        }

        if ($no_child === true){
            $count = 1;
        }

        if($count > 4 && $count != 6){
            $count = 4;
        }

        ob_start();

        if($no_child === true)
        {
            echo '<div class="menu-section">';
            echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
            echo '<div class="sjmenu sj-row">';
            echo '<div class="column sj-col-md-12" data-column="12">';
            echo '<div class="column-items-wrap">';
            if (!empty($item)) {
                echo '<h4 style="display:none" data-current_child="'.$current_menu_id.'" >'.$menuItems->getItem($current_menu_id)->title.'</h4>';
                echo '<ul class="child-menu-items">';

                foreach ($item as $key => $id)
                {
                    echo '<li>'.$menuItems->getItem($id)->title.'</li>';
                }
                echo '</ul>';
            }
            echo '<div class="modules-container">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        else
        {
            echo '<div class="menu-section">';
            echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
            echo '<div class="sjmenu sj-row">';

            $columnNumber = 12 / $count;
            foreach ($item_array as $key => $item_array)
            {
                echo '<div class="column sj-col-md-'.$columnNumber.'" data-column="'.$columnNumber.'">';
                echo '<div class="column-items-wrap">';

                foreach ($item_array as $key => $item)
                {
                    $id = $item[0];
                    echo '<h4 data-current_child="'.$id.'" >'.$menuItems->getItem($id)->title.'</h4>';
                    if ($item[1])
                    {
                        echo '<ul class="child-menu-items">';
                        echo self::create_menu($id);
                        echo '</ul>';
                    }
                }
                echo '<div class="modules-container"></div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    static public function create_menu($current_menu_id)
    {
        $items = self::menuItems();
        $menus = new JMenuSite;

        if (isset($items[$current_menu_id]))
        {
            $item = $items[$current_menu_id];
            foreach ($item as $key => $item_id)
            {
                echo '<li>';
                echo $menus->getItem($item_id)->title;
                echo '</li>';
            }
        }    
    }

    static public function menuItems()
    {
        $menus = new JMenuSite;
        $menus = $menus->getMenu();
        $new = array();
        foreach ($menus as $item) {
            $new[$item->parent_id][] = $item->id;
        }
        return $new;
    }
}