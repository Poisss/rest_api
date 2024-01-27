<?php
class Utilities{
    public function getPaging($keywords, $category, $price, $page, $total_rows, $records_per_page, $page_url): array {
        $paging_arr = [];
        $paging_attr = '';

        if(!empty($keywords)){
            $paging_attr .= '&keywords=' . $keywords; 
        }
        if(!empty($category)){
            $paging_attr .= '&category=' . $category; 
        }
        if(!empty($price)){
            $paging_attr .= '&price=' . $price; 
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