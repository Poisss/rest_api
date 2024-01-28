<?php
class Utilities{
    public function getPaging($attr_arr, $page, $total_rows, $records_per_page, $page_url): array {
        $paging_arr = [];
        $paging_attr = '';

        if(!empty($attr_arr['keywords'])){
            $paging_attr .= '&keywords=' . $attr_arr['keywords']; 
        }
        if(!empty($attr_arr['category'])){
            $paging_attr .= '&category=' . $attr_arr['category']; 
        }
        if(!empty($attr_arr['price'])){
            $paging_attr .= '&price=' . $attr_arr['price']; 
        }
        if(!empty($attr_arr['topic'])){
            $paging_attr .= '&topic=' . $attr_arr['topic']; 
        }
        if(!empty($attr_arr['user_id'])){
            $paging_attr .= '&user_id=' . $attr_arr['user_id']; 
        }
        
        $paging_arr['first'] = $page > 1 ? $page_url . 'page=1' . $paging_attr : '';

        $total_pages = ceil($total_rows / $records_per_page);        
        $paging_arr["pages"] = [];
        $page_count = 0;

        for($x = 1; $x <= $total_pages; $x++){
            $paging_arr["pages"][$page_count]["page"] = $x;
            $paging_arr["pages"][$page_count]["url"] = $page_url . 'page=' . $x . $paging_attr;
            $paging_arr["pages"][$page_count]["current_page"] = $x == $page ? "yes" : "no";
            $page_count++;
        }

        $paging_arr["last"] = $page < $total_pages ? $page_url . 'page=' . $total_pages . $paging_attr : '';

        return $paging_arr;
    }
}
?>